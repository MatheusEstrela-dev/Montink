<?php

namespace App\Http\Livewire\Produtos;

use Livewire\Component;
use App\Models\Produto;

class ListaProduto extends Component
{
    public $busca = '';

    public function render()
    {
        $produtos = Produto::where('nome', 'ilike', '%' . $this->busca . '%')
            ->orderBy('id', 'asc')
            ->get();

        return view('livewire.produtos.lista-produto', [
            'produtos' => $produtos,
        ]);
    }
}
