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
        Schema::create('cash_transactions', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date');
            $table->string('description');                    // Keterangan
            $table->enum('type', ['debit', 'credit']);        // Debit = masuk, Credit = keluar
            $table->decimal('amount', 15, 2);
            $table->decimal('balance', 15, 2)->default(0);   // Saldo setelah transaksi
            $table->string('reference')->nullable();           // Referensi (no nota, dll)
            $table->nullableMorphs('transactionable');        // Link ke sale/purchase
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_transactions');
    }
};
