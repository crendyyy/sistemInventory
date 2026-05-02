<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use App\Models\CashTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $sales = Sale::with(['customer', 'items'])
            ->when($search, function ($query, $search) {
                return $query->where('invoice_no', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('sales.index', compact('sales', 'search'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('sales.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'amount_paid' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            foreach ($validated['items'] as $item) {
                $totalAmount += ($item['quantity'] * $item['unit_price']);
            }

            $paymentStatus = 'unpaid';
            if ($validated['amount_paid'] >= $totalAmount) {
                $paymentStatus = 'paid';
            } elseif ($validated['amount_paid'] > 0) {
                $paymentStatus = 'partial';
            }

            // Generate invoice number
            $latestSale = Sale::latest('id')->first();
            $nextId = $latestSale ? $latestSale->id + 1 : 1;
            $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            $sale = Sale::create([
                'invoice_no' => $invoiceNumber,
                'customer_id' => $validated['customer_id'],
                'sale_date' => $validated['transaction_date'],
                'total' => $totalAmount,
                'subtotal' => $totalAmount, // Assuming no tax/discount applied for simplicity
                'paid_amount' => $validated['amount_paid'],
                'remaining' => max(0, $totalAmount - $validated['amount_paid']),
                'status' => $paymentStatus == 'paid' ? 'lunas' : ($paymentStatus == 'partial' ? 'sebagian' : 'belum_bayar'),
                'notes' => $validated['notes'],
            ]);

            foreach ($validated['items'] as $item) {
                $subtotal = $item['quantity'] * $item['unit_price'];

                $sale->items()->create([
                    'product_id' => $item['product_id'],
                    'qty' => $item['quantity'],
                    'unit' => 'pcs', // Default
                    'price' => $item['unit_price'],
                    'subtotal' => $subtotal,
                ]);

                // Update stock (decrement for sales)
                $product = Product::find($item['product_id']);
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok {$product->name} tidak mencukupi.");
                }
                $product->decrement('stock', $item['quantity']);
            }

            // Create Cash Transaction if paid
            if ($validated['amount_paid'] > 0) {
                CashTransaction::create([
                    'transaction_date' => $validated['transaction_date'],
                    'type' => 'debit', 
                    'amount' => $validated['amount_paid'],
                    'reference' => $invoiceNumber,
                    'description' => 'Pembayaran Penjualan ' . $invoiceNumber,
                    'transactionable_type' => Sale::class,
                    'transactionable_id' => $sale->id,
                    'user_id' => auth()->id(),
                ]);
            }

            DB::commit();

            return redirect()->route('sales.index')
                ->with('success', 'Transaksi penjualan berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Sale $sale)
    {
        $sale->load(['customer', 'items.product', 'cashTransactions']);
        return view('sales.show', compact('sale'));
    }

    public function destroy(Sale $sale)
    {
        try {
            DB::beginTransaction();

            // Reverse stock (increment back)
            foreach ($sale->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->qty);
                }
            }

            $sale->cashTransactions()->delete();
            $sale->items()->delete();
            $sale->delete();

            DB::commit();

            return redirect()->route('sales.index')
                ->with('success', 'Transaksi penjualan berhasil dihapus (Stok & Kas dikembalikan).');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Add payment to an existing sale.
     */
    public function addPayment(Request $request, Sale $sale)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'payment_notes' => 'nullable|string|max:500',
        ]);

        $amount = $request->amount;
        $maxPayable = $sale->remaining;

        if ($amount > $maxPayable) {
            return back()->with('error', "Jumlah pembayaran (Rp " . number_format($amount, 0, ',', '.') . ") melebihi sisa tagihan (Rp " . number_format($maxPayable, 0, ',', '.') . ").");
        }

        try {
            DB::beginTransaction();

            $newPaid = $sale->paid_amount + $amount;
            $newRemaining = max(0, $sale->total - $newPaid);

            // Determine new status
            $newStatus = 'belum_bayar';
            if ($newPaid >= $sale->total) {
                $newStatus = 'lunas';
            } elseif ($newPaid > 0) {
                $newStatus = 'sebagian';
            }

            $sale->update([
                'paid_amount' => $newPaid,
                'remaining' => $newRemaining,
                'status' => $newStatus,
                'paid_date' => $newStatus == 'lunas' ? $request->payment_date : null,
            ]);

            // Create Cash Transaction
            CashTransaction::create([
                'transaction_date' => $request->payment_date,
                'type' => 'debit',
                'amount' => $amount,
                'reference' => $sale->invoice_no,
                'description' => 'Pembayaran Penjualan ' . $sale->invoice_no . ($request->payment_notes ? ' - ' . $request->payment_notes : ''),
                'transactionable_type' => Sale::class,
                'transactionable_id' => $sale->id,
                'user_id' => auth()->id(),
            ]);

            DB::commit();

            return back()->with('success', 'Pembayaran sebesar Rp ' . number_format($amount, 0, ',', '.') . ' berhasil dicatat. Status: ' . ucfirst(str_replace('_', ' ', $newStatus)));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mencatat pembayaran: ' . $e->getMessage());
        }
    }
}
