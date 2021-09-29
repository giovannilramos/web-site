@extends('layouts.main')
@section('title', $produtos->nome) <!-- $pro_id->nome -->
@section('content')

    <div class="container">
		<div class="row justify-content-center" style="margin-right: 0;">
			<div class="col">
				<img id="imgPro" data-zoom-image="/img/{{$produtos->url}}" class="fotoDetalheProd" src="/img/{{$produtos->url}}">	
				
			</div>
			<div class="nomeProd col">
				{{$produtos->nome}}
				<h2>R$ {{number_format($produtos->valor,2,',','.')}}</h2>
				<form name="carrinho" method="POST" action="/carrinho/adicionar">
					@csrf
					<input type="hidden" name="id" value="{{$produtos->id}}">
					<button type="submit"  class="btn btn-success btn-lg">Adicionar ao Carrinho <i class="bi bi-cart"></i></button>
				</form>
			</div>
		</div>	 
		<div class="descricao">
			<h1>Descrição do produto</h1>
			<p>{{$produtos->desc}}</p>
		</div>
	</div>



@endsection
