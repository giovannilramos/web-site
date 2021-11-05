<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Produtos;
use PagSeguro\Configuration\Configure;
use PagSeguro\Services\Session;

class ProdutosController extends Controller
{

    private $_configs;

    public function __construct() {
        $this->_configs = new Configure();
        $this->_configs->setCharset("UTF-8");
        $this->_configs->setAccountCredentials(env('PAGSEGURO_EMAIL'),env('PAGSEGURO_TOKEN'));
        $this->_configs->setEnvironment(env('PAGSEGURO_AMBIENTE'));
        $this->_configs->setLog(true, storage_path('logs/pagseguro_'.date('Ymd').'.log'));
    }

    public function home() {
        $categorias = Categorias::all();
        return view('home',['categorias'=>$categorias]);
    }

    public function index() {
            //Vai fazer a busca pela url pela string passada
            $busca = request('search');


            $categorias = Categorias::all();

            if($busca) {
                $produtos= Produtos::where([
                    ['nome', 'like', '%'.$busca.'%']
                ])->paginate(6);
            } else {
                $produtos = Produtos::paginate(6);
            }

            return view('produtos',[
                'busca'=>$busca,
                'produtos'=>$produtos,
                'categorias'=>$categorias

            ]);
    }

    public function show($id) {
        $produtos = Produtos::findOrFail($id);


        $categorias = Categorias::all();
        return view('informacaoProd', [
            'produtos'=>$produtos,
            'categorias'=>$categorias
        ]);
    }

    public function showCate($id) {
        $categoria = Categorias::findOrFail($id);

        $produtosCate = Produtos::where([
            ['id_categorias',$categoria->id]
        ])->paginate(3);

        $categorias = Categorias::all();

        return view('produtosCategorias', [
            'produtosCate'=>$produtosCate,
            'categoria' => $categoria,
            'categorias'=>$categorias
        ]);
    }

    public function getCredential() {
        return $this->_configs->getAccountCredencials();
    }

    public function pagar() {
        $data = [];

        $sessionCode = Session::create(
            $this->getCredential()
        );
        $IDSession = $sessionCode->getResult();
        $data['sessionID'] = $IDSession;

        return view('confirmar',$data);

    }

}
