<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status'
    ];

    public function pedido_produtos() {
        return $this->hasMany('App\Models\PedidoProdutos')
        ->select(\DB::raw('produto_id, sum(desconto) as descontos, sum(valor) as valores, count(1) as qtd'))
        ->groupBy('produto_id')->orderBy('produto_id','desc');
    }

    public function pedido_produtos_itens() {
        return $this->hasMany('App\Models\PedidoProdutos');
    }

    public static function consultaId($where){
        $pedido = self::where($where)->first(['id']);
        return !empty($pedido->id)? $pedido->id : NULL;
    }
}
