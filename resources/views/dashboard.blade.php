@extends('layouts.main')
@section('title', 'Meu Perfil')
@section('content')

    <div class="container mb-3" style="border:1px solid gray;">
        <h1 style="margin-top: 10px;">Meu Perfil <i class="bi bi-person"></i></h1>

        <form action="/dashboard/update/{{ Auth::user()->id }}" method="POST"  id="dadosPerfil" name="dadosPerfil">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="nome">Nome</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ Auth::user()->name }}">
            </div>
            <div class="form-group mb-3">
                <label for="email">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ Auth::user()->email }}">
            </div>
            <div class="form-group mb-3">
                <label for="dataNasc">Data de Nascimento</label>
                <input type="date" name="dataNasc" id="dataNasc" class="form-control" value="{{ Auth::user()->dataNasc }}">
            </div>
            <div class="form-group mb-3">
                <label for="cep">CEP</label>
                <input onblur="pesquisacep(this.value);" type="text" name="cep" id="cep" class="form-control" value="{{ Auth::user()->cep }}">
            </div>
            <div class="form-group mb-3">
                <label for="cidade">Cidade</label>
                <input type="text" name="cidade" id="cidade" class="form-control" value="{{ Auth::user()->cidade }}">
            </div>
            <div class="form-group mb-3">
                <label for="uf">Estado</label>
                <select name="uf" id="uf" class="form-select">
                    <option selected>{{ Auth::user()->estado }}</option>
                    <option value="AC">AC</option>
                    <option value="AL">AL</option>
                    <option value="AP">AP</option>
                    <option value="AM">AM</option>
                    <option value="BA">BA</option>
                    <option value="CE">CE</option>
                    <option value="ES">ES</option>
                    <option value="GO">GO</option>
                    <option value="MA">MA</option>
                    <option value="MT">MT</option>
                    <option value="MS">MS</option>
                    <option value="MG">MG</option>
                    <option value="PA">PA</option>
                    <option value="PB">PB</option>
                    <option value="PR">PR</option>
                    <option value="PE">PE</option>
                    <option value="PI">PI</option>
                    <option value="RJ">RJ</option>
                    <option value="RN">RN</option>
                    <option value="RS">RS</option>
                    <option value="RO">RO</option>
                    <option value="RR">RR</option>
                    <option value="SC">SC</option>
                    <option value="SP">SP</option>
                    <option value="SE">SE</option>
                    <option value="TO">TO</option>
                    <option value="DF">DF</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="rua">Rua</label>
                <input type="text" name="rua" id="rua" class="form-control" value="{{ Auth::user()->rua }}">
            </div>
            <div class="form-group mb-3">
                <label for="bairro">Bairro</label>
                <input type="text" name="bairro" id="bairro" class="form-control" value="{{ Auth::user()->bairro }}">
            </div>
            <div class="form-group mb-3">
                <label for="numeroResidencia">Número da Residência</label>
                <input type="text" name="numeroResidencia" id="numeroResidencia" class="form-control" value="{{ Auth::user()->numeroResidencia }}">
            </div>
            <div class="form-group mb-3">
                <label for="complemento">Complemento</label>
                <input type="text" name="complemento" id="complemento" class="form-control" value="{{ Auth::user()->complemento }}">
            </div>
            <div class="form-group mb-3">
                <label for="cpf">CPF</label>
                <input type="text" name="cpf" id="cpf" class="form-control" value="{{ Auth::user()->cpf }}">
            </div>
       
            <button class="btn btn-primary mb-2">Salvar</button>
        </form>
    </div>
@endsection
