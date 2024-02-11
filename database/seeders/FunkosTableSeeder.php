<?php

namespace Database\Seeders;

use App\Models\Funko;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FunkosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Funko::create([
            'name' => 'Funko 1',
            'price' => 10.5,
            'stock' => 10,
            'image' => 'funko1.jpg',
            'category_id' => 1
        ]);
        Funko::create([
            'name' => 'Funko 2',
            'price' => 20.5,
            'stock' => 20,
            'image' => 'funko2.jpg',
            'category_id' => 2
        ]);
        Funko::create([
            'name' => 'Funko 3',
            'price' => 30.5,
            'stock' => 30,
            'image' => 'funko3.jpg',
            'category_id' => 3
        ]);
    }
}
