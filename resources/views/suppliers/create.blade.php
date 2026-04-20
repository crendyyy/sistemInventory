<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Supplier') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg max-w-2xl">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <form method="POST" action="{{ route('suppliers.store') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nama Supplier <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Contact Person</label>
                        <input type="text" name="contact_person" value="{{ old('contact_person') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Telepon</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                    </div>
                </div>

                <div>
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                </div>

                <div>
                    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Alamat</label>
                    <textarea name="address" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">{{ old('address') }}</textarea>
                </div>

                <div class="flex gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Simpan</button>
                    <a href="{{ route('suppliers.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase shadow-sm mt-0 dark:text-gray-300">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
