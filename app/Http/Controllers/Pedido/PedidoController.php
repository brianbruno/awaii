<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 22/09/2018
 * Time: 19:17
 */

namespace App\Http\Controllers\Pedido;

use App\Cliente;
use App\ItemPedido;
use App\Pedido;
use App\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PedidoController {

    public function index() {
        return view('system.pedido.index', ['pedidos' => Pedido::where('status', '<>', 'FINALIZADO')->get()]);
    }

    public function cadastrarIndex() {
        return view('system.pedido.cadastrar-pedido', ['clientes' => Cliente::all(), 'produtos' => Produto::all()]);
    }

    public function cadastrar(Request $request) {
        $validatedData = $request->validate([
            'id_cliente' => 'required',
            'cdproduto'  => 'required',
            'quantidade' => 'required|numeric'
        ]);

        try {
            DB::beginTransaction();

            $pedido = new Pedido();
            $pedido->id_cliente = $request->id_cliente;
            $pedido->save();

            $produto = Produto::find($request->cdproduto);

            $itemPedido = new ItemPedido();
            $itemPedido->id_pedido = $pedido->id;
            $itemPedido->sequencial = 1;
            $itemPedido->cdproduto = $produto->cdproduto;
            $itemPedido->quantidade = $request->quantidade;
            $itemPedido->preco = $produto->preco;
            $itemPedido->total = $itemPedido->quantidade * $produto->preco;

            $itemPedido->save();
            DB::commit();
            $response = redirect()->route('pedido-id', ['id' => $pedido->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            $response = view('system.pedido.cadastrar-pedido', ['exception' => $e->getMessage(),
                                                                      'produtos' => Produto::all(), 'stacktrace' => $e->getTraceAsString(),
                                                                      'resultado' => false, 'clientes' => Cliente::all()]);
        }

        return $response;
    }

    public function infoPedido($id) {
        return view('system.pedido.pedido', ['pedido' => Pedido::find($id), 'produtos' => Produto::all()]);
    }

    public function cadastrarItem(Request $request) {
        $validatedData = $request->validate([
            'id_pedido' => 'required',
            'cdproduto'  => 'required',
            'quantidade' => 'required|numeric'
        ]);

        $response = $this->infoPedido($request->id_pedido);

        try {
            DB::beginTransaction();

            $pedido = Pedido::find($request->id_pedido);
            $produto = Produto::find($request->cdproduto);


            $itemPedido = new ItemPedido();
            $itemPedido->id_pedido = $pedido->id;
            $itemPedido->sequencial = sizeof(ItemPedido::where('id_pedido', $request->id_pedido)->count())+1;
            $itemPedido->cdproduto = $produto->cdproduto;
            $itemPedido->quantidade = $request->quantidade;
            $itemPedido->preco = $produto->preco;
            $itemPedido->total = $itemPedido->quantidade * $produto->preco;

            $itemPedido->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $response = view('system.pedido.pedido', ['exception' => $e->getMessage(),
                'produtos' => Produto::all(), 'stacktrace' => $e->getTraceAsString(),
                'resultado' => false, 'pedido' => Pedido::find($request->id_pedido)]);
        }

        return $response;
    }

    public function finalizarPedido($id) {
        $pedido = Pedido::find($id);

        $pedido->status = 'FINALIZADO';
        $pedido->save();

        return redirect()->route('pedidos');
    }

}
