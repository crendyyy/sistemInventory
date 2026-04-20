<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pembelian: ') }} {{ $purchase->invoice_no }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Main details -->
        <div class="md:col-span-2">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Item Transaksi</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th class="px-4 py-3">Produk</th>
                                    <th class="px-4 py-3 text-right">Harga Satuan</th>
                                    <th class="px-4 py-3 text-center">Qty</th>
                                    <th class="px-4 py-3 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchase->items as $item)
                                <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                                    <td class="px-4 py-4">{{ $item->product->name ?? 'Produk tidak ditemukan' }}</td>
                                    <td class="px-4 py-4 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-4 text-center">{{ $item->qty }}</td>
                                    <td class="px-4 py-4 text-right font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="font-bold text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700">
                                    <td colspan="3" class="px-4 py-3 text-right">Total Transaksi</td>
                                    <td class="px-4 py-3 text-right text-lg">Rp {{ number_format($purchase->total, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Riwayat Pembayaran (Kas)</h3>
                    @if($purchase->cashTransactions->count() > 0)
                        <ul class="space-y-4">
                            @foreach($purchase->cashTransactions as $cash)
                            <li class="flex justify-between items-center bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($cash->transaction_date)->format('d M Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $cash->description }}</div>
                                </div>
                                <div class="font-bold text-red-600">
                                    - Rp {{ number_format($cash->amount, 0, ',', '.') }}
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 italic">Belum ada pembayaran.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar details -->
        <div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Transaksi</h3>
                    <div class="space-y-4">
                        <div>
                            <span class="block text-sm text-gray-500 dark:text-gray-400">Supplier</span>
                            <span class="block font-medium text-gray-900 dark:text-white">{{ $purchase->supplier->name ?? 'Tidak ada' }}</span>
                        </div>
                        <div>
                            <span class="block text-sm text-gray-500 dark:text-gray-400">Tanggal Transaksi</span>
                            <span class="block font-medium text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('d F Y') }}</span>
                        </div>
                        <div>
                            <span class="block text-sm text-gray-500 dark:text-gray-400">Status Pembayaran</span>
                            @if($purchase->status == 'lunas')
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Lunas</span>
                            @elseif($purchase->status == 'sebagian')
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Sebagian</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Belum Lunas</span>
                            @endif
                        </div>
                        <div>
                            <span class="block text-sm text-gray-500 dark:text-gray-400">Catatan</span>
                            <p class="text-sm font-medium text-gray-900 dark:text-white mt-1">{{ $purchase->notes ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('purchases.index') }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Kembali
            </a>
        </div>
    </div>
</x-app-layout>
