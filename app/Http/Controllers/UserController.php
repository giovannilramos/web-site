<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Categorias;
use App\Models\User;

class UserController extends Controller
{
    public function dashboard() {
        $categorias = Categorias::all();


        return view('dashboard', [
            'categorias' =>$categorias,
        ]);
    }

    public function update(Request $request) {

        User::findOrFail($request->id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'dataNasc'=>$request->dataNasc,
            'cep'=>$request->cep,
            'cidade'=>$request->cidade,
            'estado'=>$request->uf,
            'rua'=>$request->rua,
            'bairro'=>$request->bairro,
            'numeroResidencia'=>$request->numeroResidencia,
            'complemento'=>$request->complemento,
            'cpf'=>$request->cpf
            
        ]);

        return redirect('/dashboard')->with('msg', 'Dados modificados com sucesso!');
    }
}
