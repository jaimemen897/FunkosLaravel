<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'Categoria 1', 'is_deleted' => false]);
        Category::create(['name' => 'Categoria 2', 'is_deleted' => false]);
        Category::create(['name' => 'Categoria 3', 'is_deleted' => false]);
    }
}
