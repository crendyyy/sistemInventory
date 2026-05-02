<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg max-w-4xl">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <form method="POST" action="{{ route('products.update', $product) }}" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Kode Produk <span class="text-red-500">*</span></label>
                        <input type="text" name="code" value="{{ old('code', $product->code) }}" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                        @error('code') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Kategori <span class="text-red-500">*</span></label>
                        <select name="category_id" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Satuan (Unit) <span class="text-red-500">*</span></label>
                        <input type="text" name="unit" value="{{ old('unit', $product->unit) }}" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Harga Beli (Rp) <span class="text-red-500">*</span></label>
                        <input type="text" name="buy_price" value="{{ old('buy_price', preg_replace('/\.00$/','', $product->buy_price)) }}" required class="input-number mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                        <input type="text" name="sell_price" value="{{ old('sell_price', preg_replace('/\.00$/','', $product->sell_price)) }}" required class="input-number mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Stok Saat Ini <span class="text-red-500">*</span></label>
                        <input type="text" name="stock" value="{{ old('stock', $product->stock) }}" required class="input-number mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Batas Stok Minimum <span class="text-red-500">*</span></label>
                        <input type="text" name="stock_minimum" value="{{ old('stock_minimum', $product->stock_minimum) }}" required class="input-number mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Deskripsi Tambahan</label>
                    <textarea name="description" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="flex gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Simpan Perubahan</button>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase shadow-sm mt-0 dark:text-gray-300">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
