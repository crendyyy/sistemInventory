<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $products = DB::table('products')->whereNull('code')->orWhere('code', '')->orderBy('id')->get();
        
        foreach ($products as $index => $product) {
            $kode = 'PRD-' . str_pad($product->id, 4, '0', STR_PAD_LEFT);
            
            DB::table('products')->where('id', $product->id)->update([
                'code' => $kode,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse needed for data patch
    }
};
