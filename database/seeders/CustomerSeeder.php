<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            ['kode' => 'CUST-0001', 'name' => 'PT Mitra Hidrolik Mandiri', 'phone' => '0778-123456'],
            ['kode' => 'CUST-0002', 'name' => 'PT Citra Mandiri Cahaya', 'phone' => '0778-234567'],
            ['kode' => 'CUST-0003', 'name' => 'PT Batam Teknik Perkasa', 'phone' => '0778-345678'],
            ['kode' => 'CUST-0004', 'name' => 'CV Jaya Makmur Sejahtera', 'phone' => '0778-456789'],
            ['kode' => 'CUST-0005', 'name' => 'PT Karya Utama Mandiri', 'phone' => '0778-567890'],
            ['kode' => 'CUST-0006', 'name' => 'PT Bintang Samudra', 'phone' => '0778-678901'],
            ['kode' => 'CUST-0007', 'name' => 'PT Global Teknik Indonesia', 'phone' => '0778-789012'],
            ['kode' => 'CUST-0008', 'name' => 'CV Abadi Jaya Teknik', 'phone' => '0778-890123'],
        ];
        foreach ($customers as $c) {
            \App\Models\Customer::create($c);
        }
    }
}
