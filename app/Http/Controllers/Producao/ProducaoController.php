<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 23/09/2018
 * Time: 08:17
 */

namespace App\Http\Controllers\Producao;

use App\ItemPedido;
use App\Pedido;
use App\Events\PedidoRealizado;
use \Illuminate\Support\Facades\Auth;

class ProducaoController {

    public function index($message = null) {
        return view('system.producao.index', ['message' => $message]);
    }

    public function finalizarItem ($id_pedido, $id_item) {
        $item = ItemPedido::where('id_pedido', $id_pedido)
                          ->where('sequencial', $id_item)
                          ->where('unidade', Auth::user()->unidade)->get();
        $item[0]->status = 'PRODUZIDO';
        $item[0]->save();
        event(new PedidoRealizado());
        return ['resultado' => true];
    }

    public function itensProducao() {
        $return = [];

        $itens = ItemPedido::with('produto')
                  ->with('pedido')
                  ->where('unidade', '=', Auth::user()->unidade)
                  ->where('status', '<>', 'PRODUZIDO')
                  ->where('status', '<>', 'ENTREGUE')->get()->toJson();;

        return $itens;
    }

}
