<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Cupom extends Model
{
    use HasFactory;
    protected $table = 'cupoms';

    protected $fillable = [
        'codigo',
        'tipo',
        'valor',
        'data_validade',
        'ativo',
    ];

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'cupom_id');
    }
}
