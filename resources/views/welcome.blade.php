@extends('layouts.main')
{{-- Separado pela vírgula, aqui vem o nome do title --}}
@section('title', 'QuazTec')
@section('content')
    {{-- tag img laravel, link vem de public "/" + pasta "img" + nome do arquivo "fone.jpg"
    <img src="/img/fone.jpg" alt="Headset Razer"> 
    
    A variavel passada abaixo é o valor entre aspas na classe de rotas, 
    ou seja 'nome' na rota é chamado assim = $nome nessa blade
  
    {{$nome}}
    

    condição if passando nome de uma variavel passada junto com a rota
    
    @if($nome == "patati")
            <p>O nome é {{$nome}}</p>
    @endif
    

    laço de repetição for, pegando o array passado nas rotas e mostrando um por um até que 
    a variavel "i" tenha o tamanho do vetor: cont($array) = 7 (0,1,2,3,4,5,6) startando com 0 o "i"
    vai percorrer até chegar em 6 que é o valor da cont fazendo com que todos os valores sejam mostrados
    
    @for($i=0;$i < count($array); $i++)
        <p>{{$array[$i]}}</p>
    @endfor
    

    Laço de repetição foreach para percorrer vetores, ele vai (neste caso) mostrar todos os valores
    dentro do vertor nomes

    @foreach($arrNomes as $nomes)
    
    Esse $loop->index mostra as posições dos valores nos arrays, 
    ex 0 manuel (o valor manuel está no local 0 do array) 
    
        <p>{{$loop->index}}</p>
        <p>{{$nomes}}</p>
    @endforeach
    --}}

@endsection