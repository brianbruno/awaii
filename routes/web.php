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
    if (Auth::user()->level == 6) {
        return redirect('housekeeping');
    } else {
        return view('home');
    }
})->middleware('auth', 'permissao');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth', 'permissao');

Route::namespace('Pedido')->group(function () {

    Route::get('api/pedido/json/{unidade?}', 'PedidoController@pedidosJson')->middleware('auth', 'permissao');
    Route::post('api/finalizar/json/{id}/{unidade?}', 'PedidoController@finalizarJson')->middleware('auth', 'permissao');

    Route::prefix('pedido')->group(function () {

        Route::get('', 'PedidoController@index')->name('pedidos')->middleware('auth', 'permissao');
        Route::get('/{id}/{unidade?}','PedidoController@infoPedido')->where(['id' => '[0-9]+'])->name('pedido-id')->middleware('auth', 'permissao');
        Route::get('cadastro', 'PedidoController@cadastrarIndex')->middleware('auth', 'permissao');
        Route::get('finalizar/{id}/{unidade?}',  'PedidoController@finalizarPedido')->name('finalizar-pedido')->middleware('auth', 'permissao');
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
Route::view('1002', 'errors.1002');

Route::view('novo', 'novo-usuario');

Route::namespace('Housekeeping')->group(function () {

    Route::group(['prefix' => 'housekeeping',  'middleware' => ['auth', 'permissao']], function() {

        Route::view('', 'hk.index')->name('housekeeping')->middleware('auth', 'permissao');
        Route::view('adicionar-licenca', 'hk.adicionar-licenca')->middleware('auth', 'permissao');
        Route::post('adicionar-licenca',  'UnidadeController@adicionarLicenca')->name('adicionar-licenca')->middleware('auth', 'permissao');

        Route::namespace('Usuario')->group(function () {

            Route::prefix('usuarios')->group(function () {

                Route::view('', 'hk.usuario.index');
                Route::get('editar-usuario/{id}', 'UsuarioController@indexEditar')->name('usuario-id');
                Route::post('editar-usuario/{id}',  'UsuarioController@editar')->name('editar-usuario');

            });

        });

        Route::namespace('Produto')->group(function () {

            Route::prefix('produtos')->group(function () {

                Route::get('/{vue_capture?}', function () {
                    return view('hk.produto.componente-produto');
                })->where('vue_capture', '[\/\w\.-]*');
//                Route::get('', 'ProdutoController@index')->name('produtos');
                Route::view('cadastro', 'hk.produto.cadastrar-produto');
                Route::post('cadastro',  'ProdutoController@cadastrar')->name('cadastrar-produto');
                Route::get('editar-produto/{id}', 'ProdutoController@indexEditar')->name('produto-id');
            });

        });

        Route::namespace('Estoque')->group(function () {

            Route::prefix('estoque')->group(function () {

                Route::get('/{vue_capture?}', function () {
                    return view('hk.estoque.componente-estoque');
                })->where('vue_capture', '[\/\w\.-]*');
            });

        });

        Route::namespace('Cliente')->group(function () {

            Route::prefix('clientes')->group(function () {

                Route::get('', 'ClienteController@index')->name('clientes');
                Route::view('cadastro', 'hk.cliente.cadastrar-cliente');
                Route::get('editar-cliente/{id}', 'ClienteController@indexEditar')->name('cliente-id');
                Route::post('editar-cliente',  'ClienteController@editar')->name('editar-cliente');
                Route::post('cadastro',  'ClienteController@cadastrar')->name('cadastrar-cliente');

            });

        });

        Route::namespace('Unidade')->group(function () {

            Route::prefix('unidades')->group(function () {

                Route::view('', 'hk.unidade.index');
                Route::get('editar-unidade/{id}', 'UnidadeController@indexEditar')->name('unidade-id');
                Route::view('cadastro', 'hk.unidade.cadastrar-unidade');
                Route::post('cadastrar-unidade',  'UnidadeController@cadastrar')->name('cadastrar-unidade');
                Route::post('editar-unidade/{id}',  'UnidadeController@editar')->name('editar-unidade');
                Route::view('associar-unidade', 'hk.unidade.associar-unidade');
                Route::post('associar-unidade',  'UnidadeController@associar')->name('associar-unidade');

            });

        });

        Route::namespace('Relatorio')->group(function () {

            Route::prefix('relatorios')->group(function () {

                Route::get('lucroporproduto', 'RelatorioController@lucroPorProduto');

            });

        });
    });

});

Route::group(['prefix' => 'api',  'middleware' => ['auth', 'permissao']], function() {

    Route::namespace('Housekeeping')->group(function () {

        Route::namespace('Produto')->group(function () {

            Route::prefix('produtos')->group(function () {

                Route::get('produtos', 'ProdutoController@getProdutosJson');
                Route::get('{cdproduto}', 'ProdutoController@getProdutoJson');
                Route::post('adicionarreceita', 'ProdutoController@addReceita');
                Route::post('adicionarproduto', 'ProdutoController@addProduto');
                Route::post('editarproduto', 'ProdutoController@editProduto');
                Route::post('excluircomposicao', 'ProdutoController@excluirComposicaoProduto');
            });

        });

        Route::namespace('Estoque')->group(function () {

            Route::prefix('estoque')->group(function () {

                Route::get('movimentacoes', 'EstoqueController@getUltimasMovimentacoes');
                Route::post('novolancamento', 'EstoqueController@novoLancamento');
                Route::get('lancamento/{cdproduto}', 'EstoqueController@getLancamento');
                Route::post('lancamento/excluirlancamento', 'EstoqueController@excluirLancamento');
            });

        });
    });
});

Route::namespace('Management')->group(function () {

    Route::group(['prefix' => 'management',  'middleware' => ['auth', 'permissao']], function() {

        Route::view('', 'management.index');

    });

});
