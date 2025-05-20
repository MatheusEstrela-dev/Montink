<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produto extends Model
{
    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'categoria',
    ];

    public function estoque(): HasOne
    {
        return $this->hasOne(Estoque::class, 'produto_id');
    }

    public function pedidoProdutos(): HasMany
    {
        return $this->hasMany(PedidoProduto::class, 'produto_id');
    }
}
