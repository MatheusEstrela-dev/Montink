<?php

namespace Database\Factories;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

class ProdutoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Produto::class;

    /**
     * Cached array of products parsed from SQL seed file.
     *
     * @var array<int, array<string, mixed>>|null
     */
    private static ?array $produtos = null;

    /**
     * Pointer index for cycling through products.
     *
     * @var int
     */
    private static int $index = 0;

    /**
     * Load and parse products from SQL seed file.
     *
     * @return array<int, array<string, mixed>>
     */
    private function carregarProdutos(): array
    {
        if (self::$produtos === null) {
            $path = database_path('seeders/sql/produtos_gamer.sql');
            $sql = File::get($path);

            if (preg_match('/VALUES\s*(.+);/is', $sql, $matches)) {
                $valuesPart = trim($matches[1]);
                $lines = preg_split("/\),\s*\(/", trim($valuesPart, " ();"));

                self::$produtos = array_map(function (string $line) {
                    $items = str_getcsv($line, ',', "'");
                    return [
                        'nome'      => $items[0],
                        'descricao' => $items[1],
                        'preco'     => (float) $items[2],
                        'categoria' => $items[3],
                    ];
                }, $lines);
            } else {
                self::$produtos = [];
            }
        }

        return self::$produtos;
    }

    /**
     * Define the model's default state using parsed SQL data.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $produtos = $this->carregarProdutos();
        if (empty($produtos)) {
            return [];
        }

        // Cycle sequentially through predefined products
        $item = $produtos[self::$index % count($produtos)];
        self::$index++;

        return array_merge($item, [
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
