<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-900 border-none">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Produk Master Data') }}
            </h2>
            <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Tambah Produk
            </a>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <form action="{{ route('products.index') }}" method="GET" class="flex flex-col md:flex-row max-w-2xl w-full gap-2">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari kode atau nama..." class="w-full md:w-1/2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm">
                
                <select name="category_id" class="w-full md:w-1/3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Filter</button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Kode</th>
                        <th scope="col" class="px-6 py-3">Nama Produk</th>
                        <th scope="col" class="px-6 py-3">Kategori</th>
                        <th scope="col" class="px-6 py-3">Harga Beli</th>
                        <th scope="col" class="px-6 py-3">Harga Jual</th>
                        <th scope="col" class="px-6 py-3 text-center">Stok</th>
                        <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 border-b dark:border-gray-700 last:border-0">
                        <td class="px-6 py-4">{{ $product->code }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $product->name }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                {{ $product->category->name ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($product->buy_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($product->sell_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($product->stock <= $product->stock_minimum)
                                <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">{{ $product->stock }} {{ $product->unit }}</span>
                            @else
                                <span class="font-medium text-gray-900 dark:text-white">{{ $product->stock }} {{ $product->unit }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right flex justify-end gap-2">
                            <a href="{{ route('products.edit', $product) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                            
                            <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline border-none bg-transparent cursor-pointer">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada produk ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>
