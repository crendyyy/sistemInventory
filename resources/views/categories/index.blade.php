<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-900 border-none">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Kategori Master Data') }}
            </h2>
            <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Tambah Kategori
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

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <form action="{{ route('categories.index') }}" method="GET" class="flex max-w-md w-full gap-2">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari kategori..." class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">Cari</button>
                @if($search)
                    <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 rounded-md text-xs font-semibold uppercase">Reset</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-16">ID</th>
                        <th scope="col" class="px-6 py-3">Nama Kategori</th>
                        <th scope="col" class="px-6 py-3 text-center">Jumlah Produk</th>
                        <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 border-b dark:border-gray-700 last:border-0">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $category->id }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                {{ $category->products_count }} Produk
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right flex justify-end gap-2">
                            <a href="{{ route('categories.edit', $category) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                            
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline border-none bg-transparent cursor-pointer">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada data kategori ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $categories->links() }}
        </div>
    </div>
</x-app-layout>
