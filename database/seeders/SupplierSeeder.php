<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['kode' => 'SUP-0001', 'name' => 'PT Anugrah Rejeki Cemerlang', 'phone' => '0778-111001'],
            ['kode' => 'SUP-0002', 'name' => 'PT Mitra Hidrolik Mandiri', 'phone' => '0778-111002'],
            ['kode' => 'SUP-0003', 'name' => 'PT Ostynn Batam Perkasa', 'phone' => '0778-111003'],
            ['kode' => 'SUP-0004', 'name' => 'PT An-Flex Perkasa', 'phone' => '0778-111004'],
            ['kode' => 'SUP-0005', 'name' => 'PT Batam Niaga Perkasa', 'phone' => '0778-111005'],
            ['kode' => 'SUP-0006', 'name' => 'PT Citra Mandiri Cahaya', 'phone' => '0778-111006'],
            ['kode' => 'SUP-0007', 'name' => 'PT Sunway Trek Masindo', 'phone' => '0778-111007'],
            ['kode' => 'SUP-0008', 'name' => 'PT Auto Part Otomotive', 'phone' => '0778-111008'],
            ['kode' => 'SUP-0009', 'name' => 'PT Indo Selang', 'phone' => '0778-111009'],
            ['kode' => 'SUP-0010', 'name' => 'PT Amplasindo Jarta Tama', 'phone' => '0778-111010'],
            ['kode' => 'SUP-0011', 'name' => 'PT Panca Jaya Hosindo', 'phone' => '0778-111011'],
            ['kode' => 'SUP-0012', 'name' => 'PT Talenta Seal', 'phone' => '0778-111012'],
            ['kode' => 'SUP-0013', 'name' => 'PT Majesty Jaya Bersama', 'phone' => '0778-111013'],
            ['kode' => 'SUP-0014', 'name' => 'PT Bravo Maju Jaya', 'phone' => '0778-111014'],
            ['kode' => 'SUP-0015', 'name' => 'PT Bina Niaga Indonesia', 'phone' => '0778-111015'],
            ['kode' => 'SUP-0016', 'name' => 'PT Sarang Mas Sejahtera', 'phone' => '0778-111016'],
        ];
        foreach ($suppliers as $s) {
            \App\Models\Supplier::create($s);
        }
    }
}
