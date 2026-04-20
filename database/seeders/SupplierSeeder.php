<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            ['name' => 'PT Anugrah Rejeki Cemerlang'],
            ['name' => 'PT Mitra Hidrolik Mandiri'],
            ['name' => 'PT Ostynn Batam Perkasa'],
            ['name' => 'PT An-Flex Perkasa'],
            ['name' => 'PT Batam Niaga Perkasa'],
            ['name' => 'PT Citra Mandiri Cahaya'],
            ['name' => 'PT Sunway Trek Masindo'],
            ['name' => 'PT Auto Part Otomotive'],
            ['name' => 'PT Indo Selang'],
            ['name' => 'PT Amplasindo Jarta Tama'],
            ['name' => 'PT Panca Jaya Hosindo'],
            ['name' => 'PT Talenta Seal'],
            ['name' => 'PT Majesty Jaya Bersama'],
            ['name' => 'PT Bravo Maju Jaya'],
            ['name' => 'PT Bina Niaga Indonesia'],
            ['name' => 'PT Sarang Mas Sejahtera'],
        ];
        foreach ($suppliers as $s) {
            \App\Models\Supplier::create($s);
        }
    }
}
