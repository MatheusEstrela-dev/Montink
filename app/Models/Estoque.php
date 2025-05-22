<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produto;

class Estoque extends Model
{
    protected $table = 'estoques';

    protected $fillable = ['produto_id', 'quantidade', 'localizacao'];

    protected $appends = ['nome_produto'];

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }

    public function getNomeProdutoAttribute()
    {
        return $this->produto->nome ?? null;
    }
}
