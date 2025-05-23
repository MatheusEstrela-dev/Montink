<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Seed fixo para administrador da aplicação
        \App\Models\Usuario::firstOrCreate(
            ['email' => 'admin@montink.com'],
            [
                'nome' => 'Admin',
                'senha' => bcrypt('montink'),
            ]
        );

        // Criar 5 usuários
        $usuarios = \App\Models\Usuario::factory(5)->create();

        // Criar 50 produtos
        $produtos = \App\Models\Produto::factory(50)->create();

        // Estoques vinculados aos produtos
        foreach ($produtos as $produto) {
            \App\Models\Estoque::factory()->create([
                'produto_id' => $produto->id,
            ]);
        }

        // Criar 5 cupons
        \App\Models\Cupom::factory(5)->create();

        // Criar 30 pedidos com produtos
        for ($i = 0; $i < 30; $i++) {
            $pedido = \App\Models\Pedido::factory()->make();
            $pedido->usuario_id = $usuarios->random()->id;
            $pedido->save();

            $itens = $produtos->random(rand(1, 3));
            $total = 0;

            foreach ($itens as $produto) {
                $quantidade = rand(1, 2);
                $preco = $produto->preco;

                \App\Models\PedidoProduto::create([
                    'pedido_id' => $pedido->id,
                    'produto_id' => $produto->id,
                    'quantidade' => $quantidade,
                    'preco_unitario' => $preco,
                ]);

                $total += $quantidade * $preco;
            }

            $pedido->valor_total = $total;
            $pedido->save();
        }
    }
}
