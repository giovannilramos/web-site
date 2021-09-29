@extends('layouts.main')
@section('title','Contato')
@section('content')
    <h1 class="text-center">Entre em contato</h1>
    <!--Botão para redirecionar para rota principal-->
    <!--href entra o valor da rota declarada na web routes-->
    @if(isset($errors) && count($errors)>0)
    <div class="alert alert-danger">
        @foreach($errors->all() as $erro)
            <p class="text-center">{{$erro}}</p></br>
        @endforeach
    </div>
    @endif
    <form class="container" action="/contato" method="POST">
        @csrf
            @if(Auth::user())
                <div class="form-group mb-3">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" name="nome" required id="nome" value="{{Auth::user()->name}}">
                </div>
                <div class="form-group mb-3">
                    <label for="email">E-mail:</label>
                    <input type="email" class="form-control" name="email" required id="email" value="{{Auth::user()->email}}">
                </div>
            @else 
                <div class="form-group mb-3">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" name="nome" required id="nome">
                </div>
                <div class="form-group mb-3">
                    <label for="email">E-mail:</label>
                    <input type="email" class="form-control" name="email" required id="email">
                </div>
            @endif
            <div class="form-group mb-3">
                <label for="assunto">Assunto:</label>
                <input type="text" class="form-control" name="assunto" required id="assunto">
            </div>
            <div class="form-group mb-3">
                <label for="email">Mensagem:</label>
                <textarea name="mensagem" required style="resize:none;" class="form-control" rows="5" id="mensagem"></textarea>
            </div>
            <button class="btn btn-success mb-3" style="float:right; width:250px;">Enviar</button>
    </form>
    <div class="container">
        <button class="btn btn-primary mb-3" style="float:left;" onclick="redirecionar('/');">Voltar para página principal</button>
    </div>
@endsection
