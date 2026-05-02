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
                Rp {{ number_format(\App\Models\CashTransaction::active()->where('type', 'debit')->sum('amount'), 0, ',', '.') }}
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
                Rp {{ number_format(\App\Models\CashTransaction::active()->where('type', 'credit')->sum('amount'), 0, ',', '.') }}
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
                        <th scope="col" class="px-6 py-3">Diinput Oleh</th>
                        <th scope="col" class="px-6 py-3 text-right">Debit (Masuk)</th>
                        <th scope="col" class="px-6 py-3 text-right">Kredit (Keluar)</th>
                        <th scope="col" class="px-6 py-3 text-center">Status</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $cash)
                    <tr class="{{ $cash->isCancelled() ? 'bg-red-50/50 dark:bg-red-900/10 opacity-70' : 'bg-white dark:bg-gray-800' }} hover:bg-gray-50 dark:hover:bg-gray-700 border-b dark:border-gray-700 last:border-0">
                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($cash->transaction_date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="block font-medium {{ $cash->isCancelled() ? 'line-through text-gray-400 dark:text-gray-500' : 'text-gray-900 dark:text-white' }}">{{ $cash->description }}</span>
                            @if($cash->transactionable_id)
                                <span class="text-xs text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full inline-block mt-1">Sistem Otomatis</span>
                            @endif
                            @if($cash->isCancelled() && $cash->cancel_reason)
                                <span class="block text-xs text-red-500 mt-1">
                                    <strong>Alasan:</strong> {{ $cash->cancel_reason }}
                                </span>
                                <span class="block text-xs text-gray-400 mt-0.5">
                                    Dibatalkan oleh {{ $cash->cancelledByUser->name ?? 'Sistem' }} pada {{ $cash->cancelled_at->format('d/m/Y H:i') }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $cash->reference ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if($cash->user)
                                <span class="inline-flex items-center gap-1.5">
                                    <span class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xs font-bold">{{ strtoupper(substr($cash->user->name, 0, 1)) }}</span>
                                    <span class="text-gray-900 dark:text-white text-sm">{{ $cash->user->name }}</span>
                                </span>
                            @else
                                <span class="text-gray-400 text-xs italic">Sistem</span>
                            @endif
                        </td>
                        
                        <td class="px-6 py-4 text-right">
                            @if($cash->type == 'debit')
                                <span class="font-bold {{ $cash->isCancelled() ? 'line-through text-gray-400' : 'text-green-600' }}">+ Rp {{ number_format($cash->amount, 0, ',', '.') }}</span>
                            @else
                                -
                            @endif
                        </td>
                        
                        <td class="px-6 py-4 text-right">
                            @if($cash->type == 'credit')
                                <span class="font-bold {{ $cash->isCancelled() ? 'line-through text-gray-400' : 'text-red-600' }}">- Rp {{ number_format($cash->amount, 0, ',', '.') }}</span>
                            @else
                                -
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($cash->isCancelled())
                                <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Dibatalkan</span>
                            @else
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Aktif</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if(!$cash->isCancelled())
                                <button type="button" 
                                    onclick="openCancelModal({{ $cash->id }}, '{{ addslashes($cash->description) }}')" 
                                    class="font-medium text-orange-600 dark:text-orange-400 hover:underline border-none bg-transparent cursor-pointer">
                                    Cancel
                                </button>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada transaksi kas ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $transactions->links() }}
        </div>
    </div>

    <!-- Cancel Confirmation Modal -->
    <div id="cancelModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 dark:bg-gray-900 dark:bg-opacity-80 transition-opacity" onclick="closeCancelModal()"></div>

            <!-- Modal panel -->
            <div class="relative inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="cancelForm" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 dark:bg-orange-900/50 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                    Konfirmasi Cancel Transaksi
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Apakah Anda yakin ingin membatalkan transaksi ini? Transaksi yang dibatalkan <strong>tidak dapat dikembalikan</strong> dan akan tetap tercatat dalam buku kas.
                                    </p>
                                    <div class="mt-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Transaksi: <span id="cancelDescription" class="text-gray-900 dark:text-white"></span></p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">
                                        Alasan Pembatalan <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="cancel_reason" id="cancelReason" rows="3" required placeholder="Masukkan alasan pembatalan transaksi ini..." class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button type="submit" id="confirmCancelBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:w-auto sm:text-sm transition">
                            Ya, Cancel Transaksi
                        </button>
                        <button type="button" onclick="closeCancelModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openCancelModal(id, description) {
            document.getElementById('cancelModal').classList.remove('hidden');
            document.getElementById('cancelDescription').textContent = description;
            document.getElementById('cancelReason').value = '';
            document.getElementById('cancelForm').action = `/cash-transactions/${id}/cancel`;
            document.body.style.overflow = 'hidden';
        }

        function closeCancelModal() {
            document.getElementById('cancelModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeCancelModal();
        });
    </script>
</x-app-layout>
