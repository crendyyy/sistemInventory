<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Selang Hidrolik'],
            ['name' => 'Fitting & Coupling'],
            ['name' => 'O-Ring & Seal'],
            ['name' => 'Hose Clamp'],
            ['name' => 'Tube & Tubing'],
            ['name' => 'Lain-lain'],
        ];
        foreach ($categories as $cat) {
            \App\Models\Category::create($cat);
        }
    }
}
