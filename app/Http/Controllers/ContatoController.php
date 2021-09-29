<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContatoRequest;
use App\Models\Contato;
use App\Models\Categorias;

class ContatoController extends Controller
{
    public function index() {
        $categorias = Categorias::all();
        return view('contato', [
            'categorias'=>$categorias
        ]);
    }

    public function store(ContatoRequest $request) {
        $contato = new Contato;
        $contato->nome =$request->nome;
        $contato->email =$request->email;
        $contato->assunto =$request->assunto;
        $contato->mensagem =$request->mensagem;

        $contato->save();

        return redirect('/contato')->with('msg','Mensagem enviada, agradecemos o contato!');
    }
}
