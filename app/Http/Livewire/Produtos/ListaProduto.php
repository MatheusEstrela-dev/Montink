<?php

namespace App\Http\Livewire\Produtos;

use Livewire\Component;
use App\Models\Produto;
use Illuminate\Support\Facades\Log;

class ListaProduto extends Component
{
    public string $busca = '';
    public ?int $confirmarExclusaoId = null;

    protected $listeners = ['produtoExcluido' => 'render'];

    /**
     * Renderiza a lista de produtos com filtro de busca.
     */
    public function render()
    {
        try {
            $produtos = Produto::query()
                ->when($this->busca, function ($query) {
                    $query->where('nome', 'ilike', "%{$this->busca}%");
                })
                ->orderBy('id', 'asc')
                ->get();

            return view('livewire.produtos.lista-produto', [
                'produtos' => $produtos,
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao buscar produtos: ' . $e->getMessage());
            return view('livewire.produtos.lista-produto', [
                'produtos' => collect(), // Evita quebra se der erro
            ]);
        }
    }

    /**
     * Armazena o ID do produto que será excluído.
     */
    public function confirmarExclusao(int $id): void
    {
        $this->confirmarExclusaoId = $id;
    }

    /**
     * Exclui o produto do banco de dados.
     */
    public function excluirProduto(): void
    {
        if ($this->confirmarExclusaoId) {
            Produto::where('id', $this->confirmarExclusaoId)->delete();
            $this->reset('confirmarExclusaoId');
            $this->dispatchBrowserEvent('produtoExcluido');
        }
    }
}
