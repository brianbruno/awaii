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
})->middleware('auth', 'permissao');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth', 'permissao');

Route::namespace('Produto')->group(function () {

    Route::prefix('produto')->group(function () {

        Route::get('', 'ProdutoController@index')->name('produtos')->middleware('auth', 'permissao');
        Route::view('cadastro', 'system.produto.cadastrar-produto')->middleware('auth', 'permissao');
        Route::post('cadastro',  'ProdutoController@cadastrar')->name('cadastrar-produto')->middleware('auth', 'permissao');

    });

});

Route::namespace('Cliente')->group(function () {

    Route::prefix('cliente')->group(function () {

        Route::get('', 'ClienteController@index')->name('clientes')->middleware('auth', 'permissao');
        Route::view('cadastro', 'system.cliente.cadastrar-cliente')->middleware('auth', 'permissao');
        Route::post('cadastro',  'ClienteController@cadastrar')->name('cadastrar-cliente')->middleware('auth', 'permissao');

    });

});

Route::namespace('Pedido')->group(function () {

    Route::prefix('pedido')->group(function () {

        Route::get('', 'PedidoController@index')->name('pedidos')->middleware('auth', 'permissao');
        Route::get('/{id}','PedidoController@infoPedido')->where(['id' => '[0-9]+'])->name('pedido-id')->middleware('auth', 'permissao');
        Route::get('cadastro', 'PedidoController@cadastrarIndex')->middleware('auth', 'permissao');
        Route::get('finalizar/{id}',  'PedidoController@finalizarPedido')->name('finalizar-pedido')->middleware('auth', 'permissao');
        Route::get('export', 'PedidoController@export')->name('exportar-pedidos')->middleware('auth', 'permissao');
        Route::post('cadastro/item',  'PedidoController@cadastrarItem')->name('cadastrar-item')->middleware('auth', 'permissao');
        Route::post('cadastro',  'PedidoController@cadastrar')->name('cadastrar-pedido')->middleware('auth', 'permissao');

    });

});

Route::namespace('Producao')->group(function () {

    Route::get('api/producao/json', 'ProducaoController@itensProducao')->middleware('auth', 'permissao');

    Route::prefix('producao')->group(function () {

        Route::get('{message?}', 'ProducaoController@index')->name('producao')->middleware('auth', 'permissao');
        Route::post('finalizar/{id_pedido}/{id_item}', 'ProducaoController@finalizarItem')->where(['id_pedido' => '[0-9]+', 'id_item' => '[0-9]+'])
             ->name('finalizar-item')->middleware('auth', 'permissao');

    });

});

Route::view('fila', 'cliente.index');

Route::view('1001', 'errors.1001');

Route::view('novo', 'novo-usuario');

Route::namespace('Housekeeping')->group(function () {

    Route::prefix('housekeeping')->group(function () {

        Route::view('', 'hk.index')->name('housekeeping')->middleware('auth', 'permissao');
        Route::view('unidades', 'hk.unidades')->middleware('auth', 'permissao');
        Route::get('editar-unidade/{id}', 'UnidadeController@indexEditar')->name('unidade-id')->middleware('auth', 'permissao');
        Route::view('cadastrar-unidade', 'hk.cadastrar-unidade')->middleware('auth', 'permissao');
        Route::post('cadastrar-unidade',  'UnidadeController@cadastrar')->name('cadastrar-unidade')->middleware('auth', 'permissao');
        Route::post('editar-unidade',  'UnidadeController@editar')->name('editar-unidade')->middleware('auth', 'permissao');
        Route::view('associar-unidade', 'hk.associar-unidade')->middleware('auth', 'permissao');
        Route::post('associar-unidade',  'UnidadeController@associar')->name('associar-unidade')->middleware('auth', 'permissao');
    });

});
