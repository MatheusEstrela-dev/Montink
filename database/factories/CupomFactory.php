<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cupom>
 */
class CupomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $index = 0;
        $index++;

        if ($index === 1) {
            return [
                'codigo' => 'SALE20',
                'tipo' => 'percentual',
                'valor' => 20,
                'data_validade' => now()->addDays(30),
                'ativo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $tipo = $this->faker->randomElement(['percentual', 'fixo']);

        return [
            'codigo' => strtoupper($this->faker->bothify('CUPOM###')),
            'tipo' => $tipo,
            'valor' => $tipo === 'percentual'
                ? $this->faker->numberBetween(5, 50)
                : $this->faker->randomFloat(2, 5, 50),
            'data_validade' => $this->faker->dateTimeBetween('now', '+2 months'),
            'ativo' => $this->faker->boolean(80),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
