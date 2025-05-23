<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedido>
 */
class PedidoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'usuario_id' => null,
            'cupom_id' => $this->faker->boolean(50) ? $this->faker->numberBetween(1, 5) : null,
            'data_pedido' => $this->faker->dateTimeBetween('-60 days', 'now'),
            'valor_total' => 0,
            'status' => $this->faker->randomElement(['Pago', 'Enviado', 'Cancelado']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
