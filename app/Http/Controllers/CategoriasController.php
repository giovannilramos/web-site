<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorias;
use App\Models\Produtos;

class CategoriasController extends Controller
{
    public function index() {
        $categorias = Categorias::all();
        return view('layouts.main', [
            'categorias'=>$categorias
        ]);
    }

    public function show($id) {
        $categorias = Categorias::findOrFail($id);

        return view('produtosCategorias', [
            'categorias'=>$categorias,
        ]);
        
    }
}
