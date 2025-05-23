<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estoque>
 */
class EstoqueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantidade' => $this->faker->numberBetween(0, 50),
            'localizacao' => $this->faker->city,
            'produto_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
