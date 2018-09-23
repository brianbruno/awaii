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

class ProducaoController {

    public function index($message = null) {
        return view('system.producao.index', ['message' => $message]);
    }

    public function finalizarItem ($id_pedido, $id_item) {
        $item = ItemPedido::where('id_pedido', $id_pedido)->where('sequencial', $id_item)->get();
        $item[0]->status = 'PRODUZIDO';
        $item[0]->save();

        return redirect()->route('producao', ['message' => 'Item finalizado com sucesso!']);
    }

}
