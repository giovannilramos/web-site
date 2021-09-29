@extends('layouts.main')
@section('title', 'Carrinho')
@section('content')

@forelse($pedido as $pedidos)
<h2 class="text-center mb-3">Confirmar pedido</h2>
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
            <td class="align-middle text-center"><img class="imgCarrinho" src="/img/{{$pedidoProd->produto->url}}"></td>
            <td class="align-middle text-center">{{$pedidoProd->produto->nome}}</td>
            <td class="align-middle text-center">
                <div class="center-align mb-2">
                    <span class="col l4 m4 s4"> {{$pedidoProd->qtd}} </span>
                </div>
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
<form action="/carrinho/concluir" id="concluirCompra" method="POST">
    @csrf
    <input type="hidden" name="pedidos_id" id="pedidos_id" value="{{$pedidos->id}}">
    <!-- Render the radio fields and button containers -->

    <div class="form-check mb-3">
        <input class="form-check-input" type="radio" name="payment-option" value="paypal" checked>
        <img src="/img/paypal-mark.jpg" style=" height: 50px;" alt="Pague com Paypal ou Mercado Pago">
        <img src="/img/mercado-pago.png" style=" height: 50px; border:1px solid #c8c8ca;" alt="Pague com Paypal ou Mercado Pago">
    </div>
    <hr>
    <div class="form-check mb-3">
        <input class="form-check-input" type="radio" name="payment-option" value="card">
        <img src="/img/card-mark.png" style="height: 50px;" alt="Accepting Visa, Mastercard, Discover e American Express">
    </div>
    <hr>
    <div class="d-grid gap-2 col-6 mx-auto">
        <div type="submit" id="paypal-button-container"></div>
        <div id="card-button-container" class="hidden">
            <form class="row g-3" action="" method="POST">
                @csrf
                <input type="text" name="hashseller" id="hashsellere">
                <div class="col-md-12 mb-3">
                    <label for="numerocartao">Número do cartão:</label>
                    <input type="text" name="numerocartao" id="numerocartao" class="numerocartao form-control">
                </div>
                <div class="col-md-12 mb-3">
                    <label for="nome">Nome escrito no cartão:</label>
                    <input type="text" name="nome" id="nome" class="nome form-control">
                </div>
                <div class="col-md-4 mb-3" style="display: inline-block;">
                    <label for="validade">Data de validade:</label>
                    <input type="date" name="validade" id="validade" class="validade form-control">
                </div>
                <div class="col-md-3 mb-3" style="display: inline-block;">
                    <label for="cvv">CVV:</label>
                    <input type="text" name="cvv" id="cvv" class="cvv form-control">
                </div>
                <div class="col-md-4" style="display: inline-block;">
                <label for="total">Total</label>
                <div class="input-group">
                    <div class="input-group-text">R$</div>
                        <input type="text" class="total form-control" name="total" id="total">
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="parcelas">Parcelas:</label>
                    <select class="parcelas form-select" name="parcelas" id="parcelas">
                        <option value="1">1x</option>
                        <option value="2">2x</option>
                        <option value="3">3x</option>
                        <option value="4">4x</option>
                        <option value="5">5x</option>
                    </select>
                </div>
                <button style="width:100%; padding:15px;" class="btn btn-success mb-3">Continue</button>
            </form>
        </div>
    </div>
</form>

@empty
    <h4 class="alert alert-danger">Não há produtos no carrinho!</h4>
@endforelse

@endsection
