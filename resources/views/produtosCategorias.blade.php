@extends('layouts.main')
@section('title', $categoria->nome)
@section('content')

    @if(count($produtosCate)>0)
        @foreach($produtosCate as $pro)
            @if($pro->estoque > 0)
                <section class="listaProdutos">
                    <div class="H-img">
                        <a style="text-decoration: none;" target="_top" href="/produtos/info/{{$pro->id}}"><img class ="imgCatalogoProd" src="/img/{{$pro->url}}"></a>
                    </div>
                    <div class="align-list">
                        <div class="infoProd">
                            <a class="prodA" target="_top" href="/produtos/info/{{$pro->id}}">
                                <h5 class="h5Prod">{{$pro->nome}}</h5>
                            </a>
                            <h5 class="h5Prod">R$ {{number_format($pro->valor,2,',','.')}}</h5>
                            <a class="prodA" target="_top" href="/produtos/info/{{$pro->id}}"><h5 class="h5Prod">Ver Mais +</h5></a>
                            
                        </div>
                    </div>

                </section>
            @endif
        @endforeach
    @else
        <h4 class="alert alert-warning">Produto não encontrado ou indisponível no momento!</h4>
	    <button class="btn btn-success" onclick="redirecionar('/produtos')">Voltar aos produtos</button>
    @endif

    <div class="pagination justify-content-center">
        {{$produtosCate->links("pagination::bootstrap-4")}}
    </div>

@endsection