<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            ['name' => 'PT Mitra Hidrolik Mandiri', 'phone' => '0778-123456'],
            ['name' => 'PT Citra Mandiri Cahaya', 'phone' => '0778-234567'],
            ['name' => 'PT Batam Teknik Perkasa', 'phone' => '0778-345678'],
            ['name' => 'CV Jaya Makmur Sejahtera', 'phone' => '0778-456789'],
            ['name' => 'PT Karya Utama Mandiri', 'phone' => '0778-567890'],
            ['name' => 'PT Bintang Samudra', 'phone' => '0778-678901'],
            ['name' => 'PT Global Teknik Indonesia', 'phone' => '0778-789012'],
            ['name' => 'CV Abadi Jaya Teknik', 'phone' => '0778-890123'],
        ];
        foreach ($customers as $c) {
            \App\Models\Customer::create($c);
        }
    }
}
