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

        $transactions = CashTransaction::with('transactionable')
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

        // Hitung Saldo Kas Real-time
        $totalDebit = CashTransaction::where('type', 'debit')->sum('amount');
        $totalCredit = CashTransaction::where('type', 'credit')->sum('amount');
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

        CashTransaction::create($validated);

        return redirect()->route('cash-transactions.index')
            ->with('success', 'Transaksi kas manual berhasil dicatat.');
    }

    // Usually we don't allow editing/deleting accounting records directly,
    // but we can implement destroy for manual ones only if needed.
    public function destroy(CashTransaction $cashTransaction)
    {
        if ($cashTransaction->transactionable_id) {
            return back()->with('error', 'Tidak dapat menghapus transaksi kas yang terkait otomatis dengan Penjualan/Pembelian. Hapus via menu transaksi terkait.');
        }

        $cashTransaction->delete();

        return redirect()->route('cash-transactions.index')
            ->with('success', 'Transaksi kas manual berhasil dihapus.');
    }
}
