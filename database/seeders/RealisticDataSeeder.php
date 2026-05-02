<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\CashTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RealisticDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create default user if not exists
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Admin RPC',
                'email' => 'admin@rpc.com',
                'password' => bcrypt('password'),
            ]);
        }
        $userId = $user->id;
        $products = Product::all();
        $customers = Customer::all();
        $suppliers = Supplier::all();

        if ($products->isEmpty() || $customers->isEmpty() || $suppliers->isEmpty()) {
            $this->command->error('Jalankan seeder dasar dulu (Category, Supplier, Customer, Product).');
            return;
        }

        // ============================================================
        // 1. MODAL AWAL — Saldo kas awal dari setoran owner
        // ============================================================
        CashTransaction::create([
            'transaction_date' => Carbon::create(2026, 3, 1),
            'type' => 'debit',
            'amount' => 50000000,
            'reference' => 'MDL-001',
            'description' => 'Modal awal usaha — setoran owner',
            'user_id' => $userId,
            'status' => 'active',
        ]);

        CashTransaction::create([
            'transaction_date' => Carbon::create(2026, 3, 5),
            'type' => 'debit',
            'amount' => 10000000,
            'reference' => 'MDL-002',
            'description' => 'Tambahan modal kas dari owner',
            'user_id' => $userId,
            'status' => 'active',
        ]);

        // ============================================================
        // 2. PEMBELIAN — 12 transaksi (4 lunas, 4 sebagian, 4 belum bayar)
        // ============================================================
        $purchaseData = [
            // --- LUNAS (4) ---
            [
                'supplier_idx' => 0, 'date' => Carbon::create(2026, 3, 10),
                'items' => [
                    ['product_idx' => 0, 'qty' => 50, 'price' => 23725],
                    ['product_idx' => 1, 'qty' => 30, 'price' => 31525],
                ],
                'pay_type' => 'lunas', 'notes' => 'Pembelian stok awal selang R1',
            ],
            [
                'supplier_idx' => 1, 'date' => Carbon::create(2026, 3, 15),
                'items' => [
                    ['product_idx' => 4, 'qty' => 40, 'price' => 27950],
                    ['product_idx' => 5, 'qty' => 20, 'price' => 53300],
                ],
                'pay_type' => 'lunas', 'notes' => 'Restok selang R2',
            ],
            [
                'supplier_idx' => 2, 'date' => Carbon::create(2026, 4, 1),
                'items' => [
                    ['product_idx' => 7, 'qty' => 100, 'price' => 13650],
                    ['product_idx' => 8, 'qty' => 100, 'price' => 13650],
                ],
                'pay_type' => 'lunas', 'notes' => 'Stok selang oil kecil',
            ],
            [
                'supplier_idx' => 3, 'date' => Carbon::create(2026, 4, 5),
                'items' => [
                    ['product_idx' => 19, 'qty' => 200, 'price' => 8000],
                    ['product_idx' => 20, 'qty' => 300, 'price' => 2000],
                    ['product_idx' => 21, 'qty' => 10, 'price' => 125000],
                ],
                'pay_type' => 'lunas', 'notes' => 'Restok O-Ring lengkap',
            ],
            // --- SEBAGIAN (4) ---
            [
                'supplier_idx' => 4, 'date' => Carbon::create(2026, 4, 10),
                'items' => [
                    ['product_idx' => 2, 'qty' => 30, 'price' => 35750],
                    ['product_idx' => 3, 'qty' => 25, 'price' => 37700],
                ],
                'pay_type' => 'sebagian', 'pay_pct' => 50, 'notes' => 'DP 50% selang 5/8 & 3/4',
            ],
            [
                'supplier_idx' => 5, 'date' => Carbon::create(2026, 4, 15),
                'items' => [
                    ['product_idx' => 11, 'qty' => 60, 'price' => 17050],
                    ['product_idx' => 12, 'qty' => 40, 'price' => 24035],
                ],
                'pay_type' => 'sebagian', 'pay_pct' => 60, 'notes' => 'DP 60% HI POWER R1',
            ],
            [
                'supplier_idx' => 6, 'date' => Carbon::create(2026, 4, 20),
                'items' => [
                    ['product_idx' => 6, 'qty' => 15, 'price' => 72800],
                    ['product_idx' => 9, 'qty' => 20, 'price' => 32500],
                ],
                'pay_type' => 'sebagian', 'pay_pct' => 40, 'notes' => 'DP 40% selang besar',
            ],
            [
                'supplier_idx' => 7, 'date' => Carbon::create(2026, 5, 1),
                'items' => [
                    ['product_idx' => 15, 'qty' => 10, 'price' => 77000],
                    ['product_idx' => 16, 'qty' => 10, 'price' => 85800],
                ],
                'pay_type' => 'sebagian', 'pay_pct' => 30, 'notes' => 'DP 30% HI POWER 4SP',
            ],
            // --- BELUM BAYAR / PO (4) ---
            [
                'supplier_idx' => 8, 'date' => Carbon::create(2026, 5, 1),
                'items' => [
                    ['product_idx' => 10, 'qty' => 10, 'price' => 61425],
                    ['product_idx' => 13, 'qty' => 30, 'price' => 22275],
                ],
                'pay_type' => 'belum_bayar', 'notes' => 'PO belum bayar — tunggu invoice supplier',
            ],
            [
                'supplier_idx' => 9, 'date' => Carbon::create(2026, 5, 1),
                'items' => [
                    ['product_idx' => 14, 'qty' => 15, 'price' => 43725],
                    ['product_idx' => 17, 'qty' => 5, 'price' => 140800],
                ],
                'pay_type' => 'belum_bayar', 'notes' => 'PO selang R2 & 4SH — termin 30 hari',
            ],
            [
                'supplier_idx' => 10, 'date' => Carbon::create(2026, 5, 2),
                'items' => [
                    ['product_idx' => 18, 'qty' => 3, 'price' => 189750],
                ],
                'pay_type' => 'belum_bayar', 'notes' => 'PO HI POWER 1 1/4 4SH — pending approval',
            ],
            [
                'supplier_idx' => 11, 'date' => Carbon::create(2026, 5, 2),
                'items' => [
                    ['product_idx' => 19, 'qty' => 100, 'price' => 8000],
                ],
                'pay_type' => 'belum_bayar', 'notes' => 'PO tambahan oring 2*9',
            ],
        ];

        $purchaseNo = 1;
        foreach ($purchaseData as $pd) {
            $supplier = $suppliers[$pd['supplier_idx']];
            $invoiceNo = 'PUR-' . $pd['date']->format('Ymd') . '-' . str_pad($purchaseNo, 4, '0', STR_PAD_LEFT);

            $totalAmount = 0;
            $itemsToCreate = [];
            foreach ($pd['items'] as $itemData) {
                $product = $products[$itemData['product_idx']];
                $subtotal = $itemData['qty'] * $itemData['price'];
                $totalAmount += $subtotal;
                $itemsToCreate[] = [
                    'product' => $product,
                    'qty' => $itemData['qty'],
                    'price' => $itemData['price'],
                    'subtotal' => $subtotal,
                ];
            }

            $paidAmount = 0;
            if ($pd['pay_type'] === 'lunas') {
                $paidAmount = $totalAmount;
            } elseif ($pd['pay_type'] === 'sebagian') {
                $paidAmount = (int) round($totalAmount * ($pd['pay_pct'] / 100));
            }

            $purchase = Purchase::create([
                'supplier_id' => $supplier->id,
                'invoice_no' => $invoiceNo,
                'purchase_date' => $pd['date'],
                'total' => $totalAmount,
                'subtotal' => $totalAmount,
                'paid_amount' => $paidAmount,
                'remaining' => max(0, $totalAmount - $paidAmount),
                'status' => $pd['pay_type'],
                'paid_date' => $pd['pay_type'] === 'lunas' ? $pd['date'] : null,
                'notes' => $pd['notes'],
            ]);

            foreach ($itemsToCreate as $ic) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $ic['product']->id,
                    'qty' => $ic['qty'],
                    'unit' => $ic['product']->unit ?? 'pcs',
                    'price' => $ic['price'],
                    'subtotal' => $ic['subtotal'],
                ]);
                // Stok selalu nambah saat pembelian (barang sudah diterima)
                $ic['product']->increment('stock', $ic['qty']);
                $ic['product']->update(['buy_price' => $ic['price']]);
            }

            // Buat cash transaction kalau ada pembayaran
            if ($paidAmount > 0) {
                CashTransaction::create([
                    'transaction_date' => $pd['date'],
                    'type' => 'credit',
                    'amount' => $paidAmount,
                    'reference' => $invoiceNo,
                    'description' => 'Pembayaran Pembelian ' . $invoiceNo,
                    'transactionable_type' => Purchase::class,
                    'transactionable_id' => $purchase->id,
                    'user_id' => $userId,
                    'status' => 'active',
                ]);
            }

            $purchaseNo++;
        }

        // ============================================================
        // 3. PENJUALAN — 15 transaksi (6 lunas, 5 sebagian, 4 belum bayar)
        // ============================================================
        $saleData = [
            // --- LUNAS (6) ---
            [
                'customer_idx' => 0, 'date' => Carbon::create(2026, 3, 18),
                'items' => [
                    ['product_idx' => 0, 'qty' => 10, 'price' => 26500],
                    ['product_idx' => 1, 'qty' => 5, 'price' => 35000],
                ],
                'pay_type' => 'lunas', 'notes' => 'Jual selang R1 ke PT Mitra',
            ],
            [
                'customer_idx' => 1, 'date' => Carbon::create(2026, 3, 25),
                'items' => [
                    ['product_idx' => 19, 'qty' => 50, 'price' => 10000],
                    ['product_idx' => 20, 'qty' => 100, 'price' => 3500],
                ],
                'pay_type' => 'lunas', 'notes' => 'Jual O-Ring batch',
            ],
            [
                'customer_idx' => 2, 'date' => Carbon::create(2026, 4, 3),
                'items' => [
                    ['product_idx' => 7, 'qty' => 30, 'price' => 15500],
                    ['product_idx' => 8, 'qty' => 25, 'price' => 15500],
                ],
                'pay_type' => 'lunas', 'notes' => 'Jual selang oil kecil',
            ],
            [
                'customer_idx' => 3, 'date' => Carbon::create(2026, 4, 10),
                'items' => [
                    ['product_idx' => 4, 'qty' => 8, 'price' => 31500],
                    ['product_idx' => 5, 'qty' => 5, 'price' => 58500],
                ],
                'pay_type' => 'lunas', 'notes' => 'Jual selang R2',
            ],
            [
                'customer_idx' => 4, 'date' => Carbon::create(2026, 4, 18),
                'items' => [
                    ['product_idx' => 11, 'qty' => 15, 'price' => 19500],
                    ['product_idx' => 12, 'qty' => 10, 'price' => 27000],
                ],
                'pay_type' => 'lunas', 'notes' => 'Jual HI POWER R1',
            ],
            [
                'customer_idx' => 5, 'date' => Carbon::create(2026, 4, 25),
                'items' => [
                    ['product_idx' => 21, 'qty' => 3, 'price' => 145000],
                ],
                'pay_type' => 'lunas', 'notes' => 'Jual O-Ring Kit',
            ],
            // --- SEBAGIAN (5) ---
            [
                'customer_idx' => 0, 'date' => Carbon::create(2026, 4, 28),
                'items' => [
                    ['product_idx' => 2, 'qty' => 10, 'price' => 39500],
                    ['product_idx' => 3, 'qty' => 8, 'price' => 42000],
                ],
                'pay_type' => 'sebagian', 'pay_pct' => 50, 'notes' => 'DP 50% jual selang 5/8 & 3/4',
            ],
            [
                'customer_idx' => 1, 'date' => Carbon::create(2026, 5, 1),
                'items' => [
                    ['product_idx' => 6, 'qty' => 5, 'price' => 79500],
                    ['product_idx' => 9, 'qty' => 8, 'price' => 36000],
                ],
                'pay_type' => 'sebagian', 'pay_pct' => 70, 'notes' => 'Cicilan 70% selang besar',
            ],
            [
                'customer_idx' => 6, 'date' => Carbon::create(2026, 5, 1),
                'items' => [
                    ['product_idx' => 0, 'qty' => 12, 'price' => 26500],
                    ['product_idx' => 1, 'qty' => 8, 'price' => 35000],
                ],
                'pay_type' => 'sebagian', 'pay_pct' => 60, 'notes' => 'DP 60% jual selang ke PT Global',
            ],
            [
                'customer_idx' => 2, 'date' => Carbon::create(2026, 5, 2),
                'items' => [
                    ['product_idx' => 15, 'qty' => 3, 'price' => 85000],
                    ['product_idx' => 16, 'qty' => 2, 'price' => 95000],
                ],
                'pay_type' => 'sebagian', 'pay_pct' => 40, 'notes' => 'DP 40% HI POWER 4SP',
            ],
            [
                'customer_idx' => 7, 'date' => Carbon::create(2026, 5, 2),
                'items' => [
                    ['product_idx' => 19, 'qty' => 30, 'price' => 10000],
                    ['product_idx' => 20, 'qty' => 50, 'price' => 3500],
                ],
                'pay_type' => 'sebagian', 'pay_pct' => 55, 'notes' => 'Cicil 55% jual oring',
            ],
            // --- BELUM BAYAR (4) ---
            [
                'customer_idx' => 3, 'date' => Carbon::create(2026, 5, 1),
                'items' => [
                    ['product_idx' => 13, 'qty' => 10, 'price' => 25000],
                    ['product_idx' => 14, 'qty' => 5, 'price' => 48500],
                ],
                'pay_type' => 'belum_bayar', 'notes' => 'Belum bayar — termin 14 hari',
            ],
            [
                'customer_idx' => 4, 'date' => Carbon::create(2026, 5, 2),
                'items' => [
                    ['product_idx' => 10, 'qty' => 3, 'price' => 68000],
                    ['product_idx' => 17, 'qty' => 2, 'price' => 155000],
                ],
                'pay_type' => 'belum_bayar', 'notes' => 'Belum bayar — PO customer',
            ],
            [
                'customer_idx' => 5, 'date' => Carbon::create(2026, 5, 2),
                'items' => [
                    ['product_idx' => 11, 'qty' => 10, 'price' => 19500],
                ],
                'pay_type' => 'belum_bayar', 'notes' => 'Belum bayar — kirim dulu',
            ],
            [
                'customer_idx' => 6, 'date' => Carbon::create(2026, 5, 3),
                'items' => [
                    ['product_idx' => 18, 'qty' => 1, 'price' => 210000],
                    ['product_idx' => 7, 'qty' => 15, 'price' => 15500],
                ],
                'pay_type' => 'belum_bayar', 'notes' => 'Belum bayar — customer baru',
            ],
        ];

        $saleNo = 1;
        foreach ($saleData as $sd) {
            $customer = $customers[$sd['customer_idx']];
            $invoiceNo = 'INV-' . $sd['date']->format('Ymd') . '-' . str_pad($saleNo, 4, '0', STR_PAD_LEFT);

            $totalAmount = 0;
            $itemsToCreate = [];
            foreach ($sd['items'] as $itemData) {
                $product = $products[$itemData['product_idx']];
                $subtotal = $itemData['qty'] * $itemData['price'];
                $totalAmount += $subtotal;
                $itemsToCreate[] = [
                    'product' => $product,
                    'qty' => $itemData['qty'],
                    'price' => $itemData['price'],
                    'subtotal' => $subtotal,
                ];
            }

            $paidAmount = 0;
            if ($sd['pay_type'] === 'lunas') {
                $paidAmount = $totalAmount;
            } elseif ($sd['pay_type'] === 'sebagian') {
                $paidAmount = (int) round($totalAmount * ($sd['pay_pct'] / 100));
            }

            $sale = Sale::create([
                'customer_id' => $customer->id,
                'invoice_no' => $invoiceNo,
                'sale_date' => $sd['date'],
                'total' => $totalAmount,
                'subtotal' => $totalAmount,
                'paid_amount' => $paidAmount,
                'remaining' => max(0, $totalAmount - $paidAmount),
                'status' => $sd['pay_type'],
                'paid_date' => $sd['pay_type'] === 'lunas' ? $sd['date'] : null,
                'notes' => $sd['notes'],
            ]);

            foreach ($itemsToCreate as $ic) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $ic['product']->id,
                    'qty' => $ic['qty'],
                    'unit' => $ic['product']->unit ?? 'pcs',
                    'price' => $ic['price'],
                    'subtotal' => $ic['subtotal'],
                ]);
                // Kurangi stok
                $ic['product']->decrement('stock', $ic['qty']);
            }

            // Buat cash transaction kalau ada pembayaran
            if ($paidAmount > 0) {
                CashTransaction::create([
                    'transaction_date' => $sd['date'],
                    'type' => 'debit',
                    'amount' => $paidAmount,
                    'reference' => $invoiceNo,
                    'description' => 'Pembayaran Penjualan ' . $invoiceNo,
                    'transactionable_type' => Sale::class,
                    'transactionable_id' => $sale->id,
                    'user_id' => $userId,
                    'status' => 'active',
                ]);
            }

            $saleNo++;
        }

        // ============================================================
        // 4. TRANSAKSI KAS MANUAL — Operasional, Listrik, dll
        // ============================================================
        $manualTransactions = [
            // --- PENGELUARAN ---
            ['date' => Carbon::create(2026, 3, 31), 'type' => 'credit', 'amount' => 1500000, 'ref' => 'OPS-001', 'desc' => 'Bayar listrik workshop Maret 2026'],
            ['date' => Carbon::create(2026, 3, 31), 'type' => 'credit', 'amount' => 800000, 'ref' => 'OPS-002', 'desc' => 'Bayar air PDAM Maret 2026'],
            ['date' => Carbon::create(2026, 4, 1), 'type' => 'credit', 'amount' => 500000, 'ref' => 'OPS-003', 'desc' => 'Beli ATK & perlengkapan kantor'],
            ['date' => Carbon::create(2026, 4, 5), 'type' => 'credit', 'amount' => 350000, 'ref' => 'OPS-004', 'desc' => 'Biaya kurir & pengiriman barang'],
            ['date' => Carbon::create(2026, 4, 10), 'type' => 'credit', 'amount' => 2500000, 'ref' => 'OPS-005', 'desc' => 'Service mesin crimping'],
            ['date' => Carbon::create(2026, 4, 15), 'type' => 'credit', 'amount' => 250000, 'ref' => 'OPS-006', 'desc' => 'Beli bensin operasional'],
            ['date' => Carbon::create(2026, 4, 30), 'type' => 'credit', 'amount' => 1500000, 'ref' => 'OPS-007', 'desc' => 'Bayar listrik workshop April 2026'],
            ['date' => Carbon::create(2026, 4, 30), 'type' => 'credit', 'amount' => 800000, 'ref' => 'OPS-008', 'desc' => 'Bayar air PDAM April 2026'],
            ['date' => Carbon::create(2026, 5, 1), 'type' => 'credit', 'amount' => 400000, 'ref' => 'OPS-009', 'desc' => 'Beli plastik packing & isolasi'],
            ['date' => Carbon::create(2026, 5, 2), 'type' => 'credit', 'amount' => 300000, 'ref' => 'OPS-010', 'desc' => 'Biaya kurir & pengiriman Mei'],
            // --- PEMASUKAN MANUAL ---
            ['date' => Carbon::create(2026, 4, 5), 'type' => 'debit', 'amount' => 150000, 'ref' => 'JASA-001', 'desc' => 'Jasa crimping selang customer walk-in'],
            ['date' => Carbon::create(2026, 4, 12), 'type' => 'debit', 'amount' => 200000, 'ref' => 'JASA-002', 'desc' => 'Jasa potong selang custom'],
            ['date' => Carbon::create(2026, 4, 20), 'type' => 'debit', 'amount' => 350000, 'ref' => 'JASA-003', 'desc' => 'Jasa repair hydraulic hose on-site'],
            ['date' => Carbon::create(2026, 5, 1), 'type' => 'debit', 'amount' => 175000, 'ref' => 'JASA-004', 'desc' => 'Jasa crimping selang 2 unit'],
            ['date' => Carbon::create(2026, 5, 2), 'type' => 'debit', 'amount' => 500000, 'ref' => 'JASA-005', 'desc' => 'Jasa maintenance sistem hidrolik'],
        ];

        foreach ($manualTransactions as $mt) {
            CashTransaction::create([
                'transaction_date' => $mt['date'],
                'type' => $mt['type'],
                'amount' => $mt['amount'],
                'reference' => $mt['ref'],
                'description' => $mt['desc'],
                'user_id' => $userId,
                'status' => 'active',
            ]);
        }

        // --- 1 transaksi yang sudah di-cancel ---
        CashTransaction::create([
            'transaction_date' => Carbon::create(2026, 4, 8),
            'type' => 'credit',
            'amount' => 750000,
            'reference' => 'OPS-ERR',
            'description' => 'Bayar ongkir (SALAH INPUT)',
            'user_id' => $userId,
            'status' => 'cancelled',
            'cancelled_at' => Carbon::create(2026, 4, 8, 14, 0, 0),
            'cancelled_by' => $userId,
            'cancel_reason' => 'Salah input nominal, seharusnya dicatat ke rekening lain',
        ]);

        // ============================================================
        // 5. ADJUST produk yg stoknya harus kosong / menipis
        // ============================================================
        // Produk index 10 (HAMMERSPIR 1" OIL) — set stok ke 2 (menipis)
        $products[10]->update(['stock' => 2, 'stock_minimum' => 5]);
        // Produk index 17 (HI POWER 1" 4SH) — set stok ke 1 (menipis)
        $products[17]->update(['stock' => 1, 'stock_minimum' => 3]);
        // Produk index 18 (HI POWER 1 1/4" 4SH) — set stok ke 0 (habis)
        $products[18]->update(['stock' => 0, 'stock_minimum' => 2]);

        // Set stock_minimum for products that don't have it yet
        Product::where('stock_minimum', 0)->orWhereNull('stock_minimum')
            ->update(['stock_minimum' => 5]);

        $this->command->info('✅ Data realistis berhasil ditambahkan!');
        $this->command->info('   - 12 Pembelian (4 lunas, 4 sebagian, 4 belum bayar)');
        $this->command->info('   - 15 Penjualan (6 lunas, 5 sebagian, 4 belum bayar)');
        $this->command->info('   - 18 Transaksi kas manual (termasuk 1 cancelled)');
        $this->command->info('   - Modal awal 60 juta');
        $this->command->info('   - Stok bervariasi (terisi, menipis, habis)');
    }
}
