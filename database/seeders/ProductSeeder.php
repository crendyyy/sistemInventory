<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Selang Hidrolik (category_id = 1)
            ['category_id' => 1, 'name' => 'HAMMERSPIR 3/8" R1', 'unit' => 'MTR', 'buy_price' => 23725, 'sell_price' => 26500, 'stock' => 0],
            ['category_id' => 1, 'name' => 'HAMMERSPIR 1/2" R1', 'unit' => 'MTR', 'buy_price' => 31525, 'sell_price' => 35000, 'stock' => 0],
            ['category_id' => 1, 'name' => 'HAMMERSPIR 5/8" R1', 'unit' => 'MTR', 'buy_price' => 35750, 'sell_price' => 39500, 'stock' => 0],
            ['category_id' => 1, 'name' => 'HAMMERSPIR 3/4" R1', 'unit' => 'MTR', 'buy_price' => 37700, 'sell_price' => 42000, 'stock' => 0],
            ['category_id' => 1, 'name' => 'HAMMERSPIR 3/8" R2', 'unit' => 'MTR', 'buy_price' => 27950, 'sell_price' => 31500, 'stock' => 0],
            ['category_id' => 1, 'name' => 'HAMMERSPIR 3/4" R2', 'unit' => 'MTR', 'buy_price' => 53300, 'sell_price' => 58500, 'stock' => 0],
            ['category_id' => 1, 'name' => 'HAMMERSPIR 1" R2', 'unit' => 'MTR', 'buy_price' => 72800, 'sell_price' => 79500, 'stock' => 0],
            ['category_id' => 1, 'name' => 'HAMMERSPIR 5/32" OIL', 'unit' => 'MTR', 'buy_price' => 13650, 'sell_price' => 15500, 'stock' => 0],
            ['category_id' => 1, 'name' => 'HAMMERSPIR 3/16" OIL', 'unit' => 'MTR', 'buy_price' => 13650, 'sell_price' => 15500, 'stock' => 0],
            ['category_id' => 1, 'name' => 'HAMMERSPIR 5/8" OIL', 'unit' => 'MTR', 'buy_price' => 32500, 'sell_price' => 36000, 'stock' => 0],
            ['category_id' => 1, 'name' => 'HAMMERSPIR 1" OIL', 'unit' => 'MTR', 'buy_price' => 61425, 'sell_price' => 68000, 'stock' => 0],
            ['category_id' => 1, 'name' => 'HI POWER 1/4" R1', 'unit' => 'MTR', 'buy_price' => 17050, 'sell_price' => 19500, 'stock' => 0],
            ['category_id' => 1, 'name' => 'HI POWER 3/8" R1', 'unit' => 'MTR', 'buy_price' => 24035, 'sell_price' => 27000, 'stock' => 0],
            ['category_id' => 1, 'name' => 'HI POWER 1/4" R2', 'unit' => 'MTR', 'buy_price' => 22275, 'sell_price' => 25000, 'stock' => 0],
            ['category_id' => 1, 'name' => 'HI POWER 5/8" R2', 'unit' => 'MTR', 'buy_price' => 43725, 'sell_price' => 48500, 'stock' => 0],
            ['category_id' => 1, 'name' => 'HI POWER 3/8" 4SP', 'unit' => 'MTR', 'buy_price' => 77000, 'sell_price' => 85000, 'stock' => 0],
            ['category_id' => 1, 'name' => 'HI POWER 1/2" 4SP', 'unit' => 'MTR', 'buy_price' => 85800, 'sell_price' => 95000, 'stock' => 0],
            ['category_id' => 1, 'name' => 'HI POWER 1" 4SH', 'unit' => 'MTR', 'buy_price' => 140800, 'sell_price' => 155000, 'stock' => 0],
            ['category_id' => 1, 'name' => 'HI POWER 1 1/4" 4SH', 'unit' => 'MTR', 'buy_price' => 189750, 'sell_price' => 210000, 'stock' => 0],
            // O-Ring (category_id = 3)
            ['category_id' => 3, 'name' => 'ORING SIZE 2*9 NBR70', 'unit' => 'PCS', 'buy_price' => 8000, 'sell_price' => 10000, 'stock' => 0],
            ['category_id' => 3, 'name' => 'ORING SIZE 2*12 NBR70', 'unit' => 'PCS', 'buy_price' => 2000, 'sell_price' => 3500, 'stock' => 0],
            ['category_id' => 3, 'name' => 'ORING KIT', 'unit' => 'BOX', 'buy_price' => 125000, 'sell_price' => 145000, 'stock' => 0],
        ];
        foreach ($products as $p) {
            \App\Models\Product::create($p);
        }
    }
}
