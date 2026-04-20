<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-900 border-none">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Buku Kas') }}
            </h2>
            <a href="{{ route('cash-transactions.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Catat Transaksi Manual
            </a>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Cards Info Saldo -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Kas Masuk (Debit)</h3>
                <span class="p-2 bg-green-50 dark:bg-green-900/50 rounded-lg text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </span>
            </div>
            <div class="text-2xl font-bold text-gray-900 dark:text-white">
                Rp {{ number_format(\App\Models\CashTransaction::where('type', 'debit')->sum('amount'), 0, ',', '.') }}
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Kas Keluar (Kredit)</h3>
                <span class="p-2 bg-red-50 dark:bg-red-900/50 rounded-lg text-red-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                </span>
            </div>
            <div class="text-xl font-bold text-gray-900 dark:text-white">
                Rp {{ number_format(\App\Models\CashTransaction::where('type', 'credit')->sum('amount'), 0, ',', '.') }}
            </div>
        </div>

        <div class="bg-blue-600 dark:bg-blue-800 rounded-xl shadow-sm p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-blue-100">Saldo Akhir</h3>
                <span class="p-2 bg-blue-500 dark:bg-blue-700 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                </span>
            </div>
            <div class="text-2xl font-bold">
                Rp {{ number_format($saldo, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <!-- Tabel Transaksi -->
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <form action="{{ route('cash-transactions.index') }}" method="GET" class="flex flex-col md:flex-row max-w-2xl w-full gap-2">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari referensi atau deskripsi..." class="w-full md:w-1/2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm">
                
                <select name="type" class="w-full md:w-1/3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                    <option value="">Semua Tipe</option>
                    <option value="debit" {{ $type == 'debit' ? 'selected' : '' }}>Kas Masuk (Debit)</option>
                    <option value="credit" {{ $type == 'credit' ? 'selected' : '' }}>Kas Keluar (Kredit)</option>
                </select>

                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Cari</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Tanggal</th>
                        <th scope="col" class="px-6 py-3">Deskripsi</th>
                        <th scope="col" class="px-6 py-3">Referensi</th>
                        <th scope="col" class="px-6 py-3 text-right">Debit (Masuk)</th>
                        <th scope="col" class="px-6 py-3 text-right">Kredit (Keluar)</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $cash)
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 border-b dark:border-gray-700 last:border-0">
                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($cash->transaction_date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="block font-medium text-gray-900 dark:text-white">{{ $cash->description }}</span>
                            @if($cash->transactionable_id)
                                <span class="text-xs text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full inline-block mt-1">Sistem Otomatis</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $cash->reference ?? '-' }}</td>
                        
                        <td class="px-6 py-4 text-right">
                            @if($cash->type == 'debit')
                                <span class="font-bold text-green-600">+ Rp {{ number_format($cash->amount, 0, ',', '.') }}</span>
                            @else
                                -
                            @endif
                        </td>
                        
                        <td class="px-6 py-4 text-right">
                            @if($cash->type == 'credit')
                                <span class="font-bold text-red-600">- Rp {{ number_format($cash->amount, 0, ',', '.') }}</span>
                            @else
                                -
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if(!$cash->transactionable_id)
                                <form action="{{ route('cash-transactions.destroy', $cash) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan kas manual ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline border-none bg-transparent cursor-pointer">Hapus</button>
                                </form>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada transaksi kas ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $transactions->links() }}
        </div>
    </div>
</x-app-layout>
