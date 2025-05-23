<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produto extends Model
{
    use HasFactory;
    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'categoria',
    ];

    // Relacionamento com Estoques (1:N)
    public function estoques()
    {
        return $this->hasMany(Estoque::class, 'produto_id');
    }

    // Relacionamento com Pedidos (N:N)
    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'pedido_produto', 'produto_id', 'pedido_id')
            ->withPivot('quantidade', 'preco_unitario')
            ->withTimestamps();
    }
}
