<?php

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

Route::get('/', function () {
    return view('home');
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::namespace('Produto')->group(function () {

    Route::prefix('produto')->group(function () {

        Route::get('', 'ProdutoController@index')->name('produtos')->middleware('auth');
        Route::view('cadastro', 'system.produto.cadastrar-produto')->middleware('auth');
        Route::post('cadastro',  'ProdutoController@cadastrar')->name('cadastrar-produto')->middleware('auth');

    });

});

Route::namespace('Cliente')->group(function () {

    Route::prefix('cliente')->group(function () {

        Route::get('', 'ClienteController@index')->name('clientes')->middleware('auth');
        Route::view('cadastro', 'system.cliente.cadastrar-cliente')->middleware('auth');
        Route::post('cadastro',  'ClienteController@cadastrar')->name('cadastrar-cliente')->middleware('auth');

    });

});

Route::namespace('Pedido')->group(function () {

    Route::prefix('pedido')->group(function () {

        Route::get('', 'PedidoController@index')->name('pedidos')->middleware('auth');
        Route::get('/{id}','PedidoController@infoPedido')->where(['id' => '[0-9]+'])->name('pedido-id')->middleware('auth');
        Route::get('cadastro', 'PedidoController@cadastrarIndex')->middleware('auth');
        Route::get('/finalizar/{id}',  'PedidoController@finalizarPedido')->name('finalizar-pedido')->middleware('auth');
        Route::post('cadastro/item',  'PedidoController@cadastrarItem')->name('cadastrar-item')->middleware('auth');
        Route::post('cadastro',  'PedidoController@cadastrar')->name('cadastrar-pedido')->middleware('auth');

    });

});
