<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('code')->unique()->nullable(); // Kode produk
            $table->string('name');                       // HAMMERSPIR 3/8" R1, HI POWER 1/4", dll
            $table->string('unit')->default('MTR');       // MTR, PCS, BOX, EA
            $table->decimal('buy_price', 15, 2)->default(0);   // Harga beli
            $table->decimal('sell_price', 15, 2)->default(0);  // Harga jual
            $table->decimal('stock', 10, 2)->default(0);       // Stok saat ini
            $table->decimal('stock_minimum', 10, 2)->default(0); // Stok minimum (alert)
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
