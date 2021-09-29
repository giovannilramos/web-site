<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Categorias;
use App\Models\Carrinho;
use App\Models\Produtos;
use App\Models\Pedidos;
use App\Models\PedidoProdutos;
use App\Models\CupomDesconto;

class CarrinhoController extends Controller
{
    public function index() {
        $categorias = Categorias::all();

        $user = auth()->user();

        $pedido = Pedidos::where([
            'status' =>'RE',
            'user_id'=> $user->id
        ])->get();

        return view('carrinho',[
            'categorias'=>$categorias,
            'pedido'=>$pedido
        ]);
    }

    public function adicionar() {
        $req = Request();

        $user = auth()->user();

        $idProduto = $req->input('id');

        $produto = Produtos::findOrFail($idProduto);
        if (empty($produto->id)) {
            return redirect('/produtos')->with('msg','Produto não encontrado!');
        }
        
        $idPedido = Pedidos::consultaId([
            'user_id'=>$user->id,
            'status'=>'RE'
        ]);
        
        if (empty($idPedido)) {
            $pedido_novo = Pedidos::create([
                'user_id'=>$user->id,
                'status'=>'RE'
            ]);
            $idPedido = $pedido_novo->id;
        }
        PedidoProdutos::create([
            'pedidos_id'=>$idPedido,
            'produto_id'=>$idProduto,
            'valor'=>$produto->valor,
            'status'=>'RE'
        ]);
        return redirect('/carrinho')->with('msg','Produto adicionado ao carrinho com sucesso!');
    }

    public function remover() {
        $req = Request();
        $idPedido = $req->input('pedidos_id');
        $idProduto = $req->input('produto_id');
        $remove_apenas_item = (boolean)$req->input('item');
        $user = auth()->user();

        $idPedido = Pedidos::consultaId([
            'id'=>$idPedido,
            'user_id'=>$user->id,
            'status'=>'RE'
        ]);
        if(empty($idPedido)) {
            return redirect('/carrinho')->with('msg','Pedido não encontrado!');
        }

        $where_produto = [
            'pedidos_id'=>$idPedido,
            'produto_id'=>$idProduto
        ];
        $produto = PedidoProdutos::where($where_produto)->orderBy('id','desc')->first();
        if (empty($produto->id)) {
            return redirect('/carrinho')->with('msg','Produto não encontrado no carrinho!');
        }

        if ($remove_apenas_item) {
            $where_produto['id']= $produto->id;
        }
        
        PedidoProdutos::where($where_produto)->delete();

        $check_pedido = PedidoProdutos::where([
            'pedidos_id'=>$produto->pedidos_id
        ])->exists();

        if (!$check_pedido) {
            Pedidos::where([
                'id'=>$produto->pedidos_id
            ])->delete();
        }
        return redirect('/carrinho')->with('msg','Produto removido com sucesso');
    }
    
    public function concluir() {
        $req = Request();
        $idPedido = $req->input('pedidos_id');
        $user = auth()->user();
        
        $check_pedido = Pedidos::where([
            'id'=>$idPedido,
            'user_id'=>$user->id,
            'status'=>'RE'
        ])->exists();

        if (!$check_pedido) {
            return redirect('/carrinho')->with('msg','Pedido não encontratdo!');
        }
        
        $check_produtos = PedidoProdutos::where([
            'pedidos_id'=>$idPedido
        ])->exists();
        if (!$check_produtos) {
            return redirect('/carrinho')->with('msg','Produto do pedido não encontrado!');
        }

        PedidoProdutos::where([
            'pedidos_id'=>$idPedido
        ])->update([
            'status'=>'PA'
        ]);

        Pedidos::where([
            'id'=>$idPedido
        ])->update([
            'status'=>'PA'
        ]);

        return redirect('/carrinho/compras')->with('msg','Compra concluída com sucesso! Obrigado por comprar com a QuazTec!');
    }
    
    public function compras() {
        $user = auth()->user();
        $categorias = Categorias::all();
        $compras = Pedidos::where([
            'status'=>'PA',
            'user_id'=>$user->id
        ])->orderBy('created_at', 'desc')->get();

        $cancelados =  Pedidos::where([
            'status'=>'CA',
            'user_id'=>$user->id
        ])->orderBy('updated_at','desc')->get();

        return view('compras', [
            'compras'=>$compras,
            'cancelados'=>$cancelados,
            'categorias'=>$categorias
        ]);
    }
    /*
    public function cancelar() {
        $req = Request();
        $idPedido = $req->input('pedidos_id');
        $idPedidoProd = $req->input('id');
        $user = auth()->user();

        if (empty($idPedidoProd)) {
            return redirect('/carrinho/compras')->with('msg','Nenhum item selecionado para cancelamento.');
        }
        $check_pedido = Pedidos::where([
            'id'=>$idPedido,
            'user_id'=>$user->id,
            'status'=>'PA'
        ])->exists();

        if (!$check_pedido) {
            return redirect('/carrinho/compras')->with('msg','Pedido não encontrado para cancelamento.');
        }

        $check_produtos = PedidoProdutos::where([
            'pedidos_id'=>$idPedido,
            'status'=>'PA'
        ])->whereIn('id', $idPedidoProd)->exists();

        if (!($check_produtos)) {
            return redirect('/carrinho/compras')->with('msg','Produto não encontrado no pedido.');
        }

        PedidoProdutos::where([
            'pedidos_id'=>$idPedido,
            'status'=>'PA'
        ])->whereIn('id',$idPedidoProd)->update([
            'status'=>'CA'
        ]);

        $check_pedido_cancel = PedidoProdutos::where([
            'pedidos_id'=>$idPedido,
            'status'=>'PA'
        ])->exists();

        if (!$check_pedido_cancel) {
            Pedidos::where([
                'id'=>$idPedido
            ])->update([
                'status'=>'CA'
            ]);
            return redirect('/carrinho/compras')->with('msg','Compra cancelada!');
        }else {
            return redirect('/carrinho/compras')->with('msg','Item(ns) cancelado(s)!');
        }

        return redirect('/carrinho/compras');
    }
    */

    public function desconto() {
        $req = Request();
        $idPedido = $req->input('pedidos_id');
        $cupom = $req->input('cupom');
        $user = auth()->user();

        if (empty($cupom)) {
            return redirect('/carrinho')->with('msg','Cupom inválido!');
        }

        $cupom = CupomDesconto::where([
            'localizador'=>$cupom,
            'ativo'=>'s'
        ])->where('dthr_validade','>',date('Y-m-d H:i:s'))->first();

        if (empty($cupom->id)) {
            return redirect('/carrinho')->with('msg','Cupom não encontrado!');
        }

        $check_pedido = Pedidos::where([
            'id'=>$idPedido,
            'user_id'=>$user->id,
            'status'=>'RE'
        ])->exists();

        if (!$check_pedido) {
            return redirect('/carrinho')->with('msg','Pedido não encontrado para validação!');
        }

        $pedido_produtos = PedidoProdutos::where([
            'pedidos_id'=>$idPedido,
            'status'=>'RE'
        ])->get();

        if (empty($pedido_produtos)) {
            return redirect('/carrinho')->with('msg','Produto não encontrado no pedido!');
        }

        $aplicou_desconto = false;
        foreach ($pedido_produtos as $pedido_produto) {
            switch ($cupom->modo_desconto) {
                case 'porc':
                    $valor_desconto = ($pedido_produto->valor*$cupom->desconto)/100;
                    break;
                
                default:
                    $valor_desconto = $cupom->desconto;
                    break;
            }

            $valor_desconto = ($valor_desconto > $pedido_produto->valor) ? $pedido_produto->valor
             : number_format($valor_desconto, 2);
        
            switch ($cupom->modo_limite) {
                case 'qtd':
                    $qtd_pedido = PedidoProdutos::whereIn('status', ['PA','RE'])->where([
                        'cupom_descontos_id'=>$cupom->id
                    ])->count();

                    if ($qtd_pedido>= $cupom->limite) {
                        continue 2;
                    }

                    break;
                
                default:
                    $valor_ckc_descontos =  PedidoProdutos::whereIn('status',['PA','RE'])->where([
                        'cupom_descontos_id'=>$cupom->id
                    ])->sum('descontos');

                    if (($valor_ckc_descontos+$valor_desconto)>$cupom->limite) {
                        continue 2;
                    }

                    break;
            }

            $pedido_produto->cupom_descontos_id = $cupom->id;
            $pedido_produto->desconto = $valor_desconto;
            $pedido_produto->update();

            $aplicou_desconto = true;
        }
        if ($aplicou_desconto) {
            return redirect('/carrinho')->with('msg','Cupom aplicado!');
        } else {
            return redirect('/carrinho')->with('msg','Cupom esgotado!');
        }
        return redirect('/carrinho');
    }

    public function confirmar() {
        $categorias = Categorias::all();
        $user = auth()->user();
        $pedido = Pedidos::where([
            'status' =>'RE',
            'user_id'=> $user->id
        ])->get();
        return view('confirmarCompra',[
            'categorias'=>$categorias,
            'pedido'=>$pedido
        ]);
    }
}
