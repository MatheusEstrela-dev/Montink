<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PedidoProduto>
 */
class PedidoProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pedido_id' => null,
            'produto_id' => null,
            'quantidade' => $this->faker->numberBetween(1, 3),
            'preco_unitario' => $this->faker->randomFloat(2, 50, 1000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
