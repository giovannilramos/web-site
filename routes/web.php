<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\ContatoController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Rotas onde serão chamadas na URL sendo chamadas
pela primeira aspas, ou seja 
(iniciado por barra)'/nome da rota',+função vinda do controller com o local destinado */
Route::get('/events/create', [EventController::class, 'create'])->middleware('auth');
//essa página só vai existir se houver um id
Route::get('/events/{id}', [EventController::class, 'show']);
Route::post('/events', [EventController::class, 'store']);
Route::delete('/events/{id}', [EventController::class, 'destroy'])->middleware('auth');
Route::get('/events/edit/{id}', [EventController::class, 'edit'])->middleware('auth');
Route::put('/events/update/{id}', [EventController::class, 'update'])->middleware('auth');
Route::post('/events/join/{id}', [EventController::class, 'joinEvent'])->middleware('auth');
Route::delete('/events/leave/{id}', [EventController::class, 'leaveEvent'])->middleware('auth');

//teste com rota passando id sendo opcional, o "?" diz que é algo opcional na url
//esta rota também pode receber uma string na url que ele realiza a busca e ela é opcional

/*Route::get('/produto_teste/{pro_id?}', function ($pro_id = null) {
    //Vai fazer a busca pela url pela string passada
    $busca = request('search');
    return view('informacaoProd', [
        'busca'=>$busca,
        'pro_id'=>$pro_id
    ]);
});*/

/*Contato*/
Route::get('/contato', [ContatoController::class, 'index']);
Route::post('/contato', [ContatoController::class, 'store']);
/*Produtos*/
Route::get('/', [ProdutosController::class, 'home']);
Route::get('/produtos', [ProdutosController::class,'index']);
Route::get('/produtos/{id_categorias}', [ProdutosController::class,'showCate']);
Route::get('/produtos/info/{id}', [ProdutosController::class,'show']);
/*Carrinho*/
Route::get('/carrinho', [CarrinhoController::class,'index'])->middleware('auth');
Route::get('/carrinho/adicionar', [CarrinhoController::class,'index'])->middleware('auth');
Route::get('/carrinho/confirmar', [CarrinhoController::class,'confirmar'])->middleware('auth');
Route::get('/carrinho/compras', [CarrinhoController::class,'compras'])->middleware('auth');
Route::post('/carrinho/concluir', [CarrinhoController::class, 'concluir'])->middleware('auth');
//Route::post('/carrinho/cancelar', [CarrinhoController::class, 'cancelar'])->middleware('auth');
Route::post('/carrinho/adicionar', [CarrinhoController::class,'adicionar'])->middleware('auth');
Route::post('/carrinho/desconto', [CarrinhoController::class,'desconto'])->middleware('auth');
Route::delete('/carrinho/remover', [CarrinhoController::class,'remover'])->middleware('auth');
/*Dashboard*/
Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware('auth');
Route::put('/dashboard/update/{id}', [UserController::class, 'update'])->middleware('auth');
