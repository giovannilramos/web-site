@extends('layouts.main')
@section('title', 'Minhas Compras')
@section('content')

        <div class="row">
            <h1 class="text-center">Minhas compras</h1>
            <div class="mb-4">
                <h3 style="color:green;">Compras concluídas <ion-icon style="margin-bottom:-6px" name="checkmark-circle-outline"></ion-icon></h3>
                @forelse($compras as $pedidos)
                <button style="width:100%; border:1px solid grey; text-align:center" class="btn dropdown mb-2" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <h5 style="display:inline-flex; float:left;">Pedido: {{$pedidos->id}}
                    <h5 style="display:inline-flex;">Criado em: {{$pedidos->created_at->format('d/m/Y H:i')}}</h5></h5><ion-icon style="padding:5px; margin-bottom:-7px; float:right;" name="chevron-down-outline"></ion-icon>
                    <h5 style="display:inline-flex; float:right">Visualizar Pedido</h5>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li>
                        <form action="/carrinho/cancelar" method="POST">
                            @csrf
                            <input type="hidden" value="{{$pedidos->id}}" name="pedidos_id">
                            <table class="table">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="1"></th>
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
                                    @foreach($pedidos->pedido_produtos_itens as $pedidoProd)
                                    <tr>
                                        <td class="align-middle text-center">
                                            @if($pedidoProd->status == 'PA')
                                                <p class="text-center">
                                                    <input type="checkbox" id="item-{{$pedidoProd->id}}" name="id[]" value="{{$pedidoProd->id}}">
                                                </p>
                                            @else
                                                <strong style="color:red;">CANCELADO</strong>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center"><img class="imgCarrinho" src="/img/{{$pedidoProd->produto->url}}"></td>
                                        <td class="align-middle text-center">{{$pedidoProd->produto->nome}}</td>
                                        <td class="align-middle text-center">
                                            <div class="center-align mb-2">
                                                <span class="col l4 m4 s4"> {{$pedidoProd->qtd}} </span>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">R$ {{number_format($pedidoProd->produto->valor,2,',','.')}}</td>
                                        <td class="align-middle text-center">R$ {{number_format($pedidoProd->desconto,2,',','.')}}</td>
                                    </tr>
                                    @php
                                        $totalProduto = $pedidoProd->valor - $pedidoProd->desconto;
                                        $total_pedido += $totalProduto;
                                    @endphp
                                    @endforeach
                                    <tr class="table-dark">
                                        <td class="text-center"><button type="submit" class="btn btn-danger">Cancelar</button></td>
                                        <td colspan='4'></td>
                                        <td class="text-center">Total: R$ {{number_format($total_pedido,2,',','.')}} </td>
                                    </tr>
                                </tbody>	
                            </table>
                            <hr>
                        </form>
                    </li>
                </ul>
                @empty
                <h4 class="text-center alert alert-info">
                    @if($cancelados->count() > 0)
                        Neste momento, não há nenhuma compra válida!
                    @else
                        Você ainda não fez nenhuma compra!
                    @endif
                </h4>
                @endforelse
            </div>
            <div style="margin-top:10px">
                <h3 style="color:red;">Compras canceladas <ion-icon style="margin-bottom:-6px;" name="ban-outline"></ion-icon><h3>
                @forelse($cancelados as $pedidos)
                <h5  style="display:inline-flex;">Pedido: {{$pedidos->id}}</h5>
                <h5  style="display:inline-flex; float:right">Criado em: {{$pedidos->created_at}}</h5>
                <h5 style="text-align:right;">Cancelada em: {{$pedidos->updated_at}}</h5>
                <table class="table" style="margin-bottom: 30px;">
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
                        <tr class="table-dark"><td colspan='4'></td>
                            <td class="text-center">Total: R$ {{number_format($total_pedido,2,',','.')}} </td>
                        </tr>
                    </tbody>	
                </table>
                <hr>
                @empty
                    <h4 class="text-center alert alert-info">Nenhuma compra foi cancelada.</h4>
                @endforelse
            </div>
        </div>

@endsection
