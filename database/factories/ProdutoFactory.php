<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->words(2, true),
            'descricao' => $this->faker->sentence(),
            'preco' => $this->faker->randomFloat(2, 50, 1500),
            'categoria' => 'Gamers',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
