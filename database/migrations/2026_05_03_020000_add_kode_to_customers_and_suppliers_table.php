<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add kode column to customers (without unique constraint first)
        Schema::table('customers', function (Blueprint $table) {
            $table->string('kode')->after('id')->default('');
        });

        // Populate existing customers with auto-generated kode
        $customers = DB::table('customers')->orderBy('id')->get();
        foreach ($customers as $index => $customer) {
            DB::table('customers')->where('id', $customer->id)->update([
                'kode' => 'CUST-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
            ]);
        }

        // Now add unique constraint
        Schema::table('customers', function (Blueprint $table) {
            $table->unique('kode');
        });

        // Add kode column to suppliers (without unique constraint first)
        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('kode')->after('id')->default('');
        });

        // Populate existing suppliers with auto-generated kode
        $suppliers = DB::table('suppliers')->orderBy('id')->get();
        foreach ($suppliers as $index => $supplier) {
            DB::table('suppliers')->where('id', $supplier->id)->update([
                'kode' => 'SUP-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
            ]);
        }

        // Now add unique constraint
        Schema::table('suppliers', function (Blueprint $table) {
            $table->unique('kode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('kode');
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn('kode');
        });
    }
};
