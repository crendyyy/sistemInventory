<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Selang Hidrolik (category_id = 1) — index 0..18
            ['category_id' => 1, 'code' => 'PRD-0001', 'name' => 'HAMMERSPIR 3/8" R1', 'unit' => 'MTR', 'buy_price' => 23725, 'sell_price' => 26500, 'stock' => 0, 'stock_minimum' => 10],
            ['category_id' => 1, 'code' => 'PRD-0002', 'name' => 'HAMMERSPIR 1/2" R1', 'unit' => 'MTR', 'buy_price' => 31525, 'sell_price' => 35000, 'stock' => 0, 'stock_minimum' => 10],
            ['category_id' => 1, 'code' => 'PRD-0003', 'name' => 'HAMMERSPIR 5/8" R1', 'unit' => 'MTR', 'buy_price' => 35750, 'sell_price' => 39500, 'stock' => 0, 'stock_minimum' => 10],
            ['category_id' => 1, 'code' => 'PRD-0004', 'name' => 'HAMMERSPIR 3/4" R1', 'unit' => 'MTR', 'buy_price' => 37700, 'sell_price' => 42000, 'stock' => 0, 'stock_minimum' => 10],
            ['category_id' => 1, 'code' => 'PRD-0005', 'name' => 'HAMMERSPIR 3/8" R2', 'unit' => 'MTR', 'buy_price' => 27950, 'sell_price' => 31500, 'stock' => 0, 'stock_minimum' => 10],
            ['category_id' => 1, 'code' => 'PRD-0006', 'name' => 'HAMMERSPIR 3/4" R2', 'unit' => 'MTR', 'buy_price' => 53300, 'sell_price' => 58500, 'stock' => 0, 'stock_minimum' => 5],
            ['category_id' => 1, 'code' => 'PRD-0007', 'name' => 'HAMMERSPIR 1" R2', 'unit' => 'MTR', 'buy_price' => 72800, 'sell_price' => 79500, 'stock' => 0, 'stock_minimum' => 5],
            ['category_id' => 1, 'code' => 'PRD-0008', 'name' => 'HAMMERSPIR 5/32" OIL', 'unit' => 'MTR', 'buy_price' => 13650, 'sell_price' => 15500, 'stock' => 0, 'stock_minimum' => 20],
            ['category_id' => 1, 'code' => 'PRD-0009', 'name' => 'HAMMERSPIR 3/16" OIL', 'unit' => 'MTR', 'buy_price' => 13650, 'sell_price' => 15500, 'stock' => 0, 'stock_minimum' => 20],
            ['category_id' => 1, 'code' => 'PRD-0010', 'name' => 'HAMMERSPIR 5/8" OIL', 'unit' => 'MTR', 'buy_price' => 32500, 'sell_price' => 36000, 'stock' => 0, 'stock_minimum' => 5],
            ['category_id' => 1, 'code' => 'PRD-0011', 'name' => 'HAMMERSPIR 1" OIL', 'unit' => 'MTR', 'buy_price' => 61425, 'sell_price' => 68000, 'stock' => 0, 'stock_minimum' => 5],
            ['category_id' => 1, 'code' => 'PRD-0012', 'name' => 'HI POWER 1/4" R1', 'unit' => 'MTR', 'buy_price' => 17050, 'sell_price' => 19500, 'stock' => 0, 'stock_minimum' => 15],
            ['category_id' => 1, 'code' => 'PRD-0013', 'name' => 'HI POWER 3/8" R1', 'unit' => 'MTR', 'buy_price' => 24035, 'sell_price' => 27000, 'stock' => 0, 'stock_minimum' => 10],
            ['category_id' => 1, 'code' => 'PRD-0014', 'name' => 'HI POWER 1/4" R2', 'unit' => 'MTR', 'buy_price' => 22275, 'sell_price' => 25000, 'stock' => 0, 'stock_minimum' => 10],
            ['category_id' => 1, 'code' => 'PRD-0015', 'name' => 'HI POWER 5/8" R2', 'unit' => 'MTR', 'buy_price' => 43725, 'sell_price' => 48500, 'stock' => 0, 'stock_minimum' => 5],
            ['category_id' => 1, 'code' => 'PRD-0016', 'name' => 'HI POWER 3/8" 4SP', 'unit' => 'MTR', 'buy_price' => 77000, 'sell_price' => 85000, 'stock' => 0, 'stock_minimum' => 5],
            ['category_id' => 1, 'code' => 'PRD-0017', 'name' => 'HI POWER 1/2" 4SP', 'unit' => 'MTR', 'buy_price' => 85800, 'sell_price' => 95000, 'stock' => 0, 'stock_minimum' => 5],
            ['category_id' => 1, 'code' => 'PRD-0018', 'name' => 'HI POWER 1" 4SH', 'unit' => 'MTR', 'buy_price' => 140800, 'sell_price' => 155000, 'stock' => 0, 'stock_minimum' => 3],
            ['category_id' => 1, 'code' => 'PRD-0019', 'name' => 'HI POWER 1 1/4" 4SH', 'unit' => 'MTR', 'buy_price' => 189750, 'sell_price' => 210000, 'stock' => 0, 'stock_minimum' => 2],
            // O-Ring (category_id = 3) — index 19..21
            ['category_id' => 3, 'code' => 'PRD-0020', 'name' => 'ORING SIZE 2*9 NBR70', 'unit' => 'PCS', 'buy_price' => 8000, 'sell_price' => 10000, 'stock' => 0, 'stock_minimum' => 50],
            ['category_id' => 3, 'code' => 'PRD-0021', 'name' => 'ORING SIZE 2*12 NBR70', 'unit' => 'PCS', 'buy_price' => 2000, 'sell_price' => 3500, 'stock' => 0, 'stock_minimum' => 50],
            ['category_id' => 3, 'code' => 'PRD-0022', 'name' => 'ORING KIT', 'unit' => 'BOX', 'buy_price' => 125000, 'sell_price' => 145000, 'stock' => 0, 'stock_minimum' => 3],
        ];
        foreach ($products as $p) {
            \App\Models\Product::create($p);
        }
    }
}
