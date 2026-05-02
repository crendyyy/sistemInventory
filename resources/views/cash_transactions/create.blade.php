<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Catat Transaksi Kas Manual') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg max-w-2xl">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            
            <div class="mb-6 bg-blue-50 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 p-4 border-l-4 border-blue-500 rounded">
                Gunakan form ini hanya untuk penerimaan / pengeluaran kas di luar Pembelian dan Penjualan (contoh: Beban Gaji, Listrik, Modal Awal, dll).
            </div>

            <form method="POST" action="{{ route('cash-transactions.store') }}" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tanggal <span class="text-red-500">*</span></label>
                        <input type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Jenis Tranasaksi <span class="text-red-500">*</span></label>
                        <select name="type" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="">Pilih Jenis</option>
                            <option value="debit" {{ old('type') == 'debit' ? 'selected' : '' }}>Pemasukan (Debit / +)</option>
                            <option value="credit" {{ old('type') == 'credit' ? 'selected' : '' }}>Pengeluaran (Kredit / -)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Jumlah Uang (Rp) <span class="text-red-500">*</span></label>
                    <input type="text" name="amount" value="{{ old('amount') }}" required class="input-number mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                </div>

                <div>
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Keterangan / Deskripsi <span class="text-red-500">*</span></label>
                    <input type="text" name="description" value="{{ old('description') }}" required placeholder="Contoh: Bayar listrik bulan ini" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                </div>

                <div>
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">No. Referensi / Bukti <span class="text-gray-500 text-xs font-normal">(Opsional)</span></label>
                    <input type="text" name="reference" value="{{ old('reference') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                </div>

                <div class="flex gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Simpan Catatan Kas</button>
                    <a href="{{ route('cash-transactions.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase shadow-sm mt-0 dark:text-gray-300 whitespace-nowrap">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
