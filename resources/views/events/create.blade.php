@extends('layouts.main')
@section('title','Adicione')
@section('content')

<div id="event-create-container-" class="col-md-6 offset-md-3">
    <h1>Crie o seu evento:</h1> {{-- enctype="multipart/form-data" serve para colocar arquivos no form --}}
    <form action="/events" method="POST" enctype="multipart/form-data"> 
    @csrf
    <div class="form-group">
        <label for="image">Imagem do evento:</label>
        <input type="file" id="image" name="image" class="form-control-file">
    </div>
    <div class="form-group">
        <label for="date">Data do evento:</label>
        <input type="date" id="date" name="date" class="form-control">
    </div>
    <div class="form-group">
        <label for="title">Título:</label>
        <input type="text" id="title" name="title" class="form-control">
    </div>
    <div class="form-group">
        <label for="city">Cidade:</label>
        <input type="text" id="city" name="city" class="form-control">
    </div>
    <div class="form-group">
        <label for="private">É um evento privado?</label>
        <select class="form-select" name="private" id="private">
            <option value="0">Não</option>
            <option value="1">Sim</option>
        </select>
    </div>
    <div class="form-group">
        <label for="description">Descrição:</label>
        <textarea name="description" id="description" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label for="description">Adicione Itens de infraestrutura:</label>
        <div class="form-group">
            <input type="checkbox" name="items[]" value="Cadeiras">Cadeiras
        </div>
        <div class="form-group">
            <input type="checkbox" name="items[]" value="Palco">Palco
        </div>
        <div class="form-group">
            <input type="checkbox" name="items[]" value="Cerveja gratis">Cerveja gratis
        </div>
        <div class="form-group">
            <input type="checkbox" name="items[]" value="Open Food">Open Food
        </div>
        <div class="form-group">
            <input type="checkbox" name="items[]" value="Brindes">Brindes
        </div>
    </div>
    <input type="submit" class="btn btn-dark" value="Criar">
    </form>
</div>

@endsection