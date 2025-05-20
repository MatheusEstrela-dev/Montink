<?php

namespace App\Http\Livewire\Produtos;

use Livewire\Component;
use App\Models\Produto;

class Index extends Component
{
    public $nome, $preco, $categoria;

    public function salvar()
    {
        $this->validate([
            'nome' => 'required|string|max:255',
            'preco' => 'required|numeric|min:0',
            'categoria' => 'nullable|string|max:255',
        ]);

        Produto::create([
            'nome' => $this->nome,
            'preco' => $this->preco,
            'categoria' => $this->categoria,
        ]);

        $this->reset(['nome', 'preco', 'categoria']);
        session()->flash('success', 'Produto salvo com sucesso!');
    }

    public function render()
    {
        return view('livewire.produtos.index', [
            'produtos' => Produto::latest()->get()
        ]);
    }
}
