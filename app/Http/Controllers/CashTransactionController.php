<?php

namespace App\Http\Controllers;

use App\Models\CashTransaction;
use Illuminate\Http\Request;

class CashTransactionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');

        $transactions = CashTransaction::with('transactionable', 'user', 'cancelledByUser')
            ->when($search, function ($query, $search) {
                return $query->where('reference', 'like', "%{$search}%")
                             ->orWhere('description', 'like', "%{$search}%");
            })
            ->when($type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->latest('transaction_date')
            ->latest('id')
            ->paginate(15);

        // Hitung Saldo Kas Real-time (hanya transaksi aktif)
        $totalDebit = CashTransaction::active()->where('type', 'debit')->sum('amount');
        $totalCredit = CashTransaction::active()->where('type', 'credit')->sum('amount');
        $saldo = $totalDebit - $totalCredit;

        return view('cash_transactions.index', compact('transactions', 'search', 'type', 'saldo'));
    }

    public function create()
    {
        return view('cash_transactions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_date' => 'required|date',
            'type' => 'required|in:debit,credit',
            'amount' => 'required|numeric|min:1',
            'reference' => 'nullable|string|max:255',
            'description' => 'required|string',
        ]);

        $validated['user_id'] = auth()->id();

        CashTransaction::create($validated);

        return redirect()->route('cash-transactions.index')
            ->with('success', 'Transaksi kas manual berhasil dicatat.');
    }

    /**
     * Cancel a cash transaction (soft cancel - record is kept).
     */
    public function cancel(Request $request, CashTransaction $cashTransaction)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:500',
        ]);

        if ($cashTransaction->isCancelled()) {
            return back()->with('error', 'Transaksi ini sudah di-cancel sebelumnya.');
        }

        $cashTransaction->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancelled_by' => auth()->id(),
            'cancel_reason' => $request->cancel_reason,
        ]);

        return redirect()->route('cash-transactions.index')
            ->with('success', 'Transaksi kas berhasil di-cancel.');
    }
}
