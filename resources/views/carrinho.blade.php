@extends('layouts.main')
@section('title', 'Carrinho')
@section('content')

@forelse($pedido as $pedidos)
<h2 class="text-center mb-3">Carrinho de compras</h2>
<table class="table">
    <thead class="table-dark">
        <tr>
            <th scope="col" class="text-center">Produto</th>
            <th scope="col" class="text-center">Nome</th>
            <th scope="col" class="text-center">Quantidade</th>
            <th scope="col" class="text-center">Valor Unit.</th>
            <th scope="col" class="text-center">Desconto(s)</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total_pedido = 0;
        @endphp
        @foreach($pedidos->pedido_produtos as $pedidoProd)
        <tr>
            <td class="align-middle text-center"><img class="imgCarrinho" alt="Carrinho" src="/img/{{$pedidoProd->produto->url}}"></td>
            <td class="align-middle text-center">{{$pedidoProd->produto->nome}}</td>
            <td class="align-middle text-center">
                <div class="center-align mb-2">
                    <a style="text-decoration: none; color:none;" onclick="carrinhoRemoverProduto({{$pedidos->id}},{{$pedidoProd->produto_id}},1)" href="#" class="col l4 m4 s4">
                        <ion-icon style="margin-bottom:-2px;" name="remove-circle-outline">-</ion-icon>
                    </a>
                    <span class="col l4 m4 s4"> {{$pedidoProd->qtd}} </span>
                    <a style="text-decoration: none; color:none;" onclick="carrinhoAdicionarProduto({{$pedidoProd->produto_id}})" href="#" class="col l4 m4 s4">
                        <ion-icon style="margin-bottom:-2px;" name="add-circle-outline">+</ion-icon>
                    </a>
                </div>
                <button class="btn btn-danger" onclick="carrinhoRemoverProduto({{$pedidos->id}},{{$pedidoProd->produto_id}},0)">
                    <ion-icon style="margin-bottom:-2px;" name="trash-outline"></ion-icon> Retirar produtos
                </button>
            </td>
            <td class="align-middle text-center">R$ {{number_format($pedidoProd->produto->valor,2,',','.')}}</td>
            <td class="align-middle text-center">R$ {{number_format($pedidoProd->descontos,2,',','.')}}</td>
        </tr>
        @php
            $totalProduto = $pedidoProd->valores - $pedidoProd->descontos;
            $total_pedido += $totalProduto;
        @endphp
        @endforeach
        <tr class="table-dark">
            <td>

            </td>
            <td colspan='3'></td>
            <td class="text-center">Total: R$ {{number_format($total_pedido,2,',','.')}} </td>
        </tr>

    </tbody>
</table>
<form style="display:inline-flex" class="p-2" action="/carrinho/desconto" method="POST">
    @csrf
    <input type="hidden" name="pedidos_id" value="{{$pedidos->id}}">
    <input style="display:inline-flex; width:auto;" class="form-control" type="text" name="cupom" placeholder="Digite seu cupom:">
    <button class="btn btn-success">Aplicar</button>
</form>
    <div class="d-flex float-end">
        <div class="p-2">
            <a style="font-family: arial" href="/produtos" class="btn btn-primary">Voltar aos produtos</a>
        </div>
        <div class="p-2">
            <button type="submit" onclick="redirecionar('/carrinho/confirmar');" class="btn btn-success">Confirmar Compra</button>
        </div>
    </div>
@empty
    <h4 class="alert alert-danger">Não há produtos no carrinho!</h4>
    <div class="d-grid gap-2 col-6 mx-auto">
        <button class="btn btn-primary btn-lg" style="float:left;" onclick="redirecionar('/produtos');">Voltar à loja</button>
    </div>
@endforelse
<form action="/carrinho/remover" method="POST" id="form-remover-produto" name="form-remover-produto">
    @csrf
    @method('DELETE')
    <input type="hidden" name="pedidos_id" id="pedidos_id">
    <input type="hidden" name="produto_id" id="produto_id">
    <input type="hidden" name="item" id="item">
</form>
<form action="/carrinho/adicionar" method="POST" id="form-adicionar-produto" name="form-adicionar-produto">
    @csrf
    <input type="hidden" name="id" id="id">
</form>

@push('scripts')
    <script src="/js/javascript.js"></script>
@endpush

@endsection
