<?php

namespace Database\Seeders;

use App\Models\Category;
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
            'name' => 'Funko Batman',
            'price' => 10.5,
            'stock' => 10,
            'image' => 'batman.jpg',
            'category_id' => Category::where('name', 'Categoria 1')->first()->id
        ]);
        Funko::create([
            'name' => 'Funko Darth Vader',
            'price' => 20.5,
            'stock' => 20,
            'image' => 'darth_vader.jpg',
            'category_id' => Category::where('name', 'Categoria 2')->first()->id
        ]);
        Funko::create([
            'name' => 'Funko Harry Potter',
            'price' => 30.5,
            'stock' => 30,
            'image' => 'harry_potter.jpg',
            'category_id' => Category::where('name', 'Categoria 3')->first()->id
        ]);
        Funko::create([
            'name' => 'Funko Mickey Mouse',
            'price' => 40.5,
            'stock' => 40,
            'image' => 'mickey_mouse.jpg',
            'category_id' => Category::where('name', 'Categoria 1')->first()->id
        ]);
    }
}
