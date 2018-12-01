<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 22/09/2018
 * Time: 19:17
 */

namespace App\Http\Controllers\Housekeeping\Pedido;

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
        return view('system.pedido.index');
    }

    public function infoPedido($id, $unidade = '') {
        $unidade = Auth::user()->unidade;
        return view('system.pedido.pedido', ['pedido' => Pedido::getPedido($id, $unidade), 'produtos' => Produto::all(),
                        'itens' => ItemPedido::getItensPedido($id, $unidade) ]);
    }

    public function cadastrarItem(Request $request) {
        $validatedData = $request->validate([
            'id_pedido' => 'required',
            'cdproduto'  => 'required',
            'quantidade' => 'required|numeric'
        ]);

        $response = $this->infoPedido($request->id_pedido, Auth::user()->unidade);

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

    public function finalizarPedido($id, $unidade = '') {
        $return = null;
        $unidade = Auth::user()->unidade;
        $finalizarPedido = $this->finalizarPedidoFinal($id, $unidade);

        if ($finalizarPedido['codigo'] == 1) {
            $view = 'system.pedido.pedido';
            $return = view($view, ['pedido' => Pedido::find($id, $unidade), 'produtos' => Produto::all(), 'message' => $finalizarPedido['mensagem']]);
        } else if ($finalizarPedido['codigo'] == 200) {
            $return = redirect()->route('pedidos');
        } else if ($finalizarPedido['codigo'] == 2) {
            $return = view('system.pedido.pedido', ['exception' => $finalizarPedido['mensagem'],
                'produtos' => Produto::all(), 'stacktrace' => $finalizarPedido['stacktrace'],
                'resultado' => false, 'pedido' => Pedido::where('id', $id)->where('unidade', $unidade)->with('cliente')->get()[0]]);
        }
        return $return;
    }

    public function finalizarPedidoFinal($id, $unidade) {

        $resultado = array(
            'resultado' => false,
            'mensagem'  => 'Erro ao realizar a operação',
            'codigo'    => 1
        );

        try {
            DB::beginTransaction();

            $pedido = Pedido::where('id', $id)
                ->where('unidade', $unidade)->first();

            $itens = ItemPedido::where('status', '<>', 'PRODUZIDO')
                ->where('id_pedido', $id)
                ->where('unidade', $unidade)->count();

            if ($itens == 0) {
                $pedido->status = 'FINALIZADO';
                $pedido->save();
                $itens = ItemPedido::where('id_pedido', $id)
                    ->where('unidade', $unidade)->update(['status' => 'ENTREGUE']);
                event(new PedidoEntregue($id, $unidade));
                $resultado['codigo']   = 200;
                $resultado['mensagem'] = 'Operação realizada com sucesso.';
            } else {
                $resultado['codigo']   = 1;
                $resultado['mensagem'] = 'Não foi possível finalizar esse pedido. Nem todos os itens foram produzidos.';
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $resultado['mensagem'] = $e->getMessage();
            $resultado['stacktrace'] = $e->getTraceAsString();
            $resultado['line'] = $e->getLine();
            $resultado['trace'] = $e->getTrace();
            $resultado['code'] = $e->getCode();
        }

        return $resultado;
    }

    public function export(){
        return Excel::download(new PedidosExport, 'pedidos-'.date('d-m-Y-Hi').'.xlsx');
    }

    public function pedidosJson($unidade = '') {
        $unidade = Auth::user()->unidade;
        return Pedido::getPedidosPendentes($unidade);
    }

    public function finalizarJson($id, $unidade = '') {
        return $finalizarPedido = $this->finalizarPedidoFinal($id, $unidade);
    }

    public function novoPedidoApi(Request $request) {

        $resultado = array(
            'resultado' => false,
            'mensagem'  => 'Erro ao realizar a operação',
            'codigo'    => 1
        );

        $validatedData = $request->validate([
            'produtos' => 'required',
            'total'  => 'required'
        ]);

        try {
            DB::beginTransaction();

            $produtos = $request->produtos;

            $unidade = Auth::user()->unidade;

            $contador = Pedido::CONTADOR.$unidade;

            $novoCodigo = NovoCodigo::retrieve($contador);
            $codigo = $novoCodigo->getProxCodigo();

            $pedido = new Pedido();
            $pedido->id_cliente = null;
            $pedido->id = $codigo;
            $pedido->unidade = $unidade;
            $pedido->id_ultatu = Auth::user()->id;

            $pedido->save();

            $sequencial = 1;

            foreach($produtos as $produto_rqst) {
                $produto = Produto::find($produto_rqst['cdproduto']);

                $itemPedido = new ItemPedido();
                $itemPedido->id_pedido = $pedido->id;
                $itemPedido->sequencial = $sequencial;
                $itemPedido->cdproduto = $produto->cdproduto;
                $itemPedido->quantidade = $produto_rqst['quantidade'];
                $itemPedido->preco = $produto->preco;
                $itemPedido->total = $itemPedido->quantidade * $produto->preco;
                $itemPedido->unidade = Auth::user()->unidade;

                $itemPedido->save();

                $sequencial++;
            }

            DB::commit();
            event(new PedidoRealizado());

            $resultado = array(
                'resultado' => true,
                'mensagem'  => 'Operação realizada com sucesso.',
                'codigo'    => 200
            );
        } catch (\Exception $e) {
            DB::rollBack();
            $resultado['mensagem'] = $e->getMessage();
            $resultado['stacktrace'] = $e->getTraceAsString();
            $resultado['line'] = $e->getLine();
            $resultado['trace'] = $e->getTrace();
            $resultado['code'] = $e->getCode();
        }

        return $resultado;
    }

}
