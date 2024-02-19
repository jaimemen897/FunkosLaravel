<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Funko;
use Illuminate\Database\Eloquent\Factories\Factory;

class FunkoFactory extends Factory
{
    protected $model = Funko::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 0, 100),
            'stock' => $this->faker->randomNumber(2),
            'image' => $this->faker->imageUrl(640, 480),
            'category_id' => Category::factory(),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
