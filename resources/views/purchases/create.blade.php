<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Pembelian Baru') }}
        </h2>
    </x-slot>

    @php
        $productsData = $products->map(function($p) { 
            return ['id' => $p->id, 'name' => $p->name, 'price' => $p->buy_price, 'stock' => $p->stock]; 
        });
    @endphp
    <!-- Alpine.js Product Data to pass to JS -->
    <script>
        const productsData = @json($productsData);
    </script>

    @if ($errors->any())
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
        <strong class="font-bold">Terjadi kesalahan!</strong>
        <ul class="list-disc pl-5 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100" 
             x-data="purchaseForm()">
            <form method="POST" action="{{ route('purchases.store') }}">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Supplier -->
                    <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Supplier <span class="text-red-500">*</span></label>
                        <select name="supplier_id" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                            <option value="">Pilih Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->kode }} - {{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date -->
                    <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tanggal Pembelian <span class="text-red-500">*</span></label>
                        <input type="date" name="transaction_date" value="{{ date('Y-m-d') }}" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                    </div>
                </div>

                <!-- Repeater Items -->
                <div class="mb-8 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="font-medium text-gray-900 dark:text-white">Item Produk</h3>
                        <button type="button" @click="addItem()" class="inline-flex items-center px-3 py-1 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                            + Tambah Item
                        </button>
                    </div>
                    <div class="p-4 space-y-4">
                        <template x-for="(item, index) in items" :key="item.id">
                            <div class="flex flex-col md:flex-row items-end gap-4 p-4 border border-blue-100 dark:border-blue-900/30 rounded-lg bg-blue-50/30 dark:bg-blue-900/10">
                                
                                <div class="w-full md:w-5/12">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-400 mb-1">Produk <span class="text-red-500">*</span></label>
                                    <select x-model="item.product_id" :name="`items[${index}][product_id]`" @change="productChanged(item)" required class="block w-full text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                        <option value="">-- Pilih --</option>
                                        <template x-for="p in availableProducts" :key="p.id">
                                            <option :value="p.id" x-text="p.name"></option>
                                        </template>
                                    </select>
                                </div>

                                <div class="w-full md:w-2/12">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-400 mb-1">Harga Beli Baru (Rp) <span class="text-red-500">*</span></label>
                                    <input type="text" :value="item.unit_price ? new Intl.NumberFormat('id-ID').format(item.unit_price) : ''" @input="let val = $event.target.value.replace(/[^0-9]/g, ''); item.unit_price = val ? parseInt(val) : 0; $event.target.value = val ? new Intl.NumberFormat('id-ID').format(val) : '';" required class="block w-full text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                    <input type="hidden" :name="`items[${index}][unit_price]`" :value="item.unit_price">
                                    <span class="text-[10px] text-gray-500 mt-1 block" x-show="item.product_id">
                                        HPP Lama: Rp <span x-text="formatMoney(getCurrentHPP(item.product_id))"></span>
                                    </span>
                                </div>

                                <div class="w-full md:w-2/12">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-400 mb-1">Qty <span class="text-red-500">*</span></label>
                                    <input type="text" :value="item.quantity ? new Intl.NumberFormat('id-ID').format(item.quantity) : ''" @input="let val = $event.target.value.replace(/[^0-9]/g, ''); item.quantity = val ? parseInt(val) : 0; $event.target.value = val ? new Intl.NumberFormat('id-ID').format(val) : '';" required class="block w-full text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                    <input type="hidden" :name="`items[${index}][quantity]`" :value="item.quantity">
                                </div>

                                <div class="w-full md:w-3/12">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-400 mb-1">Subtotal</label>
                                    <div class="flex items-center gap-2">
                                        <input type="text" readonly :value="'Rp ' + formatMoney(item.unit_price * item.quantity)" class="block w-full text-sm bg-gray-100 border-gray-300 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 rounded-md shadow-sm opacity-70">
                                        
                                        <button type="button" @click="removeItem(index)" class="p-2 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 focus:outline-none">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </div>
                                
                            </div>
                        </template>
                        
                        <div x-show="items.length === 0" class="text-center py-6 text-gray-500 text-sm">
                            Belum ada item ditambahkan.
                        </div>
                    </div>
                </div>

                <!-- Footer Summary & Payment -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                    <div>
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Catatan Tambahan</label>
                        <textarea name="notes" rows="4" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"></textarea>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg space-y-4 border border-gray-200 dark:border-gray-600">
                        <div class="flex justify-between items-center pb-4 border-b border-gray-300 dark:border-gray-600">
                            <span class="text-gray-700 dark:text-gray-300 font-medium text-lg">Total Pembelian</span>
                            <span class="text-xl font-bold text-gray-900 dark:text-white" x-text="'Rp ' + formatMoney(calculateTotal())"></span>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Jumlah Dibayar Lunas (Rp) <span class="text-red-500">*</span></label>
                            <div class="flex gap-2">
                                <input type="text" :value="amountPaid ? new Intl.NumberFormat('id-ID').format(amountPaid) : ''" @input="let val = $event.target.value.replace(/[^0-9]/g, ''); amountPaid = val ? parseInt(val) : 0; $event.target.value = val ? new Intl.NumberFormat('id-ID').format(val) : '';" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                <input type="hidden" name="amount_paid" :value="amountPaid">
                                <button type="button" @click="amountPaid = calculateTotal()" class="px-3 py-2 bg-gray-200 text-gray-800 text-sm rounded hover:bg-gray-300 dark:bg-gray-600 dark:text-gray-200 dark:hover:bg-gray-500 whitespace-nowrap">
                                    Set Lunas
                                </button>
                            </div>
                            <p class="text-xs mt-2" :class="amountPaid < calculateTotal() ? 'text-red-500' : 'text-green-600 dark:text-green-400'">
                                <span x-show="amountPaid < calculateTotal()">Kekurangan: <span x-text="'Rp ' + formatMoney(calculateTotal() - amountPaid)"></span> (Hutang)</span>
                                <span x-show="amountPaid >= calculateTotal() && calculateTotal() > 0">Lunas / Terbayar Penuh</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('purchases.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase shadow-sm hover:bg-gray-50 dark:text-gray-300">Batal</a>
                    <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-bold text-xs text-white uppercase hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Simpan & Proses</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Alpine Widget Setup -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('purchaseForm', () => ({
                availableProducts: productsData,
                items: [{ id: Date.now(), product_id: '', quantity: 1, unit_price: 0 }],
                amountPaid: 0,
                
                addItem() {
                    this.items.push({
                        id: Date.now(),
                        product_id: '',
                        quantity: 1,
                        unit_price: 0
                    });
                },
                
                removeItem(index) {
                    if(this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                },
                
                productChanged(item) {
                    const product = this.availableProducts.find(p => p.id == item.product_id);
                    if (product && item.unit_price == 0) {
                        item.unit_price = product.price; // Gunakan angka aslinya, tanpa titik
                    }
                },
                
                getCurrentHPP(productId) {
                    if (!productId) return 0;
                    const product = this.availableProducts.find(p => p.id == productId);
                    return product ? product.price : 0;
                },
                
                calculateTotal() {
                    return this.items.reduce((total, item) => total + (item.quantity * item.unit_price), 0);
                },

                formatMoney(amount) {
                    return Number(amount).toLocaleString('id-ID');
                }
            }));
        });
    </script>
</x-app-layout>
