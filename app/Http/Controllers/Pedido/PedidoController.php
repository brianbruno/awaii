<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 22/09/2018
 * Time: 19:17
 */

namespace App\Http\Controllers\Pedido;

use App\Cliente;
use App\Events\PedidoEntregue;
use App\Events\PedidoRealizado;
use App\ItemPedido;
use App\NovoCodigo;
use App\Pedido;
use App\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\PedidosExport;
use Maatwebsite\Excel\Facades\Excel;

class PedidoController {

    public function index() {
        $pedidos = Pedido::where('status', '<>', 'FINALIZADO')
                         ->where('unidade', Auth::user()->unidade)
                         ->with('cliente')->get();
        return view('system.pedido.index', ['pedidos' => $pedidos]);
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

            $contador = Pedido::CONTADOR.Auth::user()->unidade;

            $novoCodigo = NovoCodigo::retrieve($contador);
            $pedido = new Pedido();
            DB::rollBack();
            dump('oi');die;
            $pedido->id = $novoCodigo->getProxCodigo();
            $pedido->id_cliente = $request->id_cliente;
            $pedido->unidade = Auth::user()->unidade;
            $pedido->id_ultatu = Auth::user()->id;
            
            $pedido->save();

            $produto = Produto::find($request->cdproduto);

            $itemPedido = new ItemPedido();
            $itemPedido->id_pedido = $pedido->id;
            $itemPedido->sequencial = 1;
            $itemPedido->cdproduto = $produto->cdproduto;
            $itemPedido->quantidade = $request->quantidade;
            $itemPedido->preco = $produto->preco;
            $itemPedido->total = $itemPedido->quantidade * $produto->preco;
            $itemPedido->unidade = Auth::user()->unidade;

            $itemPedido->save();
            DB::commit();
            event(new PedidoRealizado());
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
        return view('system.pedido.pedido', ['pedido' => Pedido::where('id', $id)->where('unidade', Auth::user()->unidade)->get()[0], 'produtos' => Produto::all()]);
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
            $itemPedido->sequencial = ItemPedido::where('id_pedido', $request->id_pedido)->count() + 1;
            $itemPedido->cdproduto = $produto->cdproduto;
            $itemPedido->quantidade = $request->quantidade;
            $itemPedido->preco = $produto->preco;
            $itemPedido->total = $itemPedido->quantidade * $produto->preco;
            $itemPedido->unidade = Auth::user()->unidade;

            $itemPedido->save();
            DB::commit();
            event(new PedidoRealizado());
        } catch (\Exception $e) {
            DB::rollBack();
            $response = view('system.pedido.pedido', ['exception' => $e->getMessage(),
                'produtos' => Produto::all(), 'stacktrace' => $e->getTraceAsString(),
                'resultado' => false, 'pedido' => Pedido::find($request->id_pedido)]);
        }

        return $response;
    }

    public function finalizarPedido($id) {
        $return = null;
        $unidade = Auth::user()->unidade;
        try {
            DB::beginTransaction();

            $pedido = Pedido::where('id', $id)
                            ->where('unidade', $unidade)->get()[0];

            $itens = ItemPedido::where('status', '<>', 'PRODUZIDO')
                               ->where('id_pedido', $id)
                               ->where('unidade', $unidade)->count();

    //        dump($pedido);die;

            if ($itens == 0) {
                $pedido->status = 'FINALIZADO';
                $pedido->save();
                $itens->update(['status' => 'ENTREGUE']);
                event(new PedidoEntregue($pedido));
                $return = redirect()->route('pedidos');
            } else {
                $mensagem = 'Não foi possível finalizar esse pedido. Nem todos os itens foram produzidos.';
                $view = 'system.pedido.pedido';

                $return = view($view, ['pedido' => Pedido::find($id, $unidade), 'produtos' => Produto::all(), 'message' => $mensagem]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $return = view('system.pedido.pedido', ['exception' => $e->getMessage(),
                'produtos' => Produto::all(), 'stacktrace' => $e->getTraceAsString(),
                'resultado' => false, 'pedido' => Pedido::where('id', $id)->where('unidade', $unidade)->with('cliente')->get()[0]]);
        }

        return $return;
    }

    public function export(){
        return Excel::download(new PedidosExport, 'pedidos-'.date('d-m-Y-Hi').'.xlsx');
    }

}
