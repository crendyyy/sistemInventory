<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\CashTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Nilai Stok (Harga Beli * Stok)
        $nilaiStok = Product::sum(DB::raw('buy_price * stock'));

        // 2. Penjualan & Pembelian Bulan Ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $penjualanBulanIni = Sale::whereMonth('sale_date', $currentMonth)
                                 ->whereYear('sale_date', $currentYear)
                                 ->sum('total');

        $pembelianBulanIni = Purchase::whereMonth('purchase_date', $currentMonth)
                                     ->whereYear('purchase_date', $currentYear)
                                     ->sum('total');

        // 3. Saldo Kas
        $totalDebit = CashTransaction::active()->where('type', 'debit')->sum('amount');
        $totalCredit = CashTransaction::active()->where('type', 'credit')->sum('amount');
        $saldoKas = $totalDebit - $totalCredit;

        // 4. Produk Stok Menipis
        $lowStockProducts = Product::whereColumn('stock', '<=', 'stock_minimum')
                                   ->with('category')
                                   ->take(10)
                                   ->get();

        // 5. Piutang (Penjualan Belum Lunas)
        $piutang = Sale::whereIn('status', ['belum_bayar', 'sebagian'])
                       ->with('customer')
                       ->take(5)
                       ->get();

        // 6. Pembelian Inden (Belum Diterima)
        $indenPurchases = Purchase::where('is_inden', true)
                                  ->where('inden_received', false)
                                  ->with('supplier')
                                  ->latest()
                                  ->take(5)
                                  ->get();

        return view('dashboard', compact(
            'nilaiStok', 
            'penjualanBulanIni', 
            'pembelianBulanIni', 
            'saldoKas',
            'lowStockProducts',
            'piutang',
            'indenPurchases'
        ));
    }
}
