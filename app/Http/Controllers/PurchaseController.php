<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\CashTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $purchases = Purchase::with(['supplier', 'items'])
            ->when($search, function ($query, $search) {
                return $query->where('invoice_no', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('purchases.index', compact('purchases', 'search'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('purchases.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
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
            $latestPurchase = Purchase::latest('id')->first();
            $nextId = $latestPurchase ? $latestPurchase->id + 1 : 1;
            $invoiceNumber = 'PO-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            $purchase = Purchase::create([
                'invoice_no' => $invoiceNumber,
                'supplier_id' => $validated['supplier_id'],
                'purchase_date' => $validated['transaction_date'],
                'total' => $totalAmount,
                'subtotal' => $totalAmount,
                'paid_amount' => $validated['amount_paid'],
                'remaining' => max(0, $totalAmount - $validated['amount_paid']),
                'status' => $paymentStatus == 'paid' ? 'lunas' : ($paymentStatus == 'partial' ? 'sebagian' : 'belum_bayar'),
                'notes' => $validated['notes'],
            ]);

            foreach ($validated['items'] as $item) {
                $subtotal = $item['quantity'] * $item['unit_price'];

                $purchase->items()->create([
                    'product_id' => $item['product_id'],
                    'qty' => $item['quantity'],
                    'unit' => 'pcs',
                    'price' => $item['unit_price'],
                    'subtotal' => $subtotal,
                ]);

                // Update stock
                $product = Product::find($item['product_id']);
                $product->increment('stock', $item['quantity']);
            }

            // Create Cash Transaction if paid
            if ($validated['amount_paid'] > 0) {
                CashTransaction::create([
                    'transaction_date' => $validated['transaction_date'],
                    'type' => 'credit', 
                    'amount' => $validated['amount_paid'],
                    'reference' => $invoiceNumber,
                    'description' => 'Pembayaran Pembelian ' . $invoiceNumber,
                    'transactionable_type' => Purchase::class,
                    'transactionable_id' => $purchase->id,
                    'user_id' => auth()->id(),
                ]);
            }

            DB::commit();

            return redirect()->route('purchases.index')
                ->with('success', 'Transaksi pembelian berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['supplier', 'items.product', 'cashTransactions']);
        return view('purchases.show', compact('purchase'));
    }

    public function destroy(Purchase $purchase)
    {
        try {
            DB::beginTransaction();

            // Reverse stock
            foreach ($purchase->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('stock', $item->qty);
                }
            }

            $purchase->cashTransactions()->delete();
            $purchase->items()->delete();
            $purchase->delete();

            DB::commit();

            return redirect()->route('purchases.index')
                ->with('success', 'Transaksi pembelian berhasil dihapus (Stok & Kas dikembalikan).');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}
