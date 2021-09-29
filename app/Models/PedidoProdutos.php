<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoProdutos extends Model
{
    use HasFactory;

    protected $fillable = [
        'pedidos_id',
        'produto_id',
        'cupom_descontos_id',
        'status',
        'valor',
        'desconto'
    ];

    public function produto() {
        return $this->belongsTo('App\Models\Produtos', 'produto_id', 'id');
    }
}
