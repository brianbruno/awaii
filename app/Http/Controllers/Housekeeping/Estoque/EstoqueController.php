<?php

namespace App\Http\Controllers\Housekeeping\Estoque;

use App\ItemLancamento;
use App\Lancamento;
use App\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstoqueController {

    public function getUltimasMovimentacoes() {
        return Lancamento::getUltimasMovimentacoes();
    }

    public function novoLancamento(Request $request) {
        $validatedData = $request->validate([
            'tipo' => 'required|max:1',
        ]);

        $return = array('resultado' => false);

        if (!empty($request->produtos)) {
            try {
                $produtos = $request->produtos;

                DB::beginTransaction();

                $lancamento = new Lancamento();
                $lancamento->tipo = $request->tipo;
                $lancamento->unidade = Auth::user()->unidade;
                $lancamento->id_ultatu = Auth::user()->id;
                $lancamento->save();

                foreach ($produtos as $produto) {
                    $prod = Produto::find($produto['cdproduto']);
                    $receita = $prod->receita()->get();

                    $parametros = array(
                        'id'        => $lancamento->id,
                        'cdproduto' => $produto['cdproduto'],
                        'quantidade' => $produto['quantidade'],
                        'precounitario' => $produto['precounitario']);

                    $this->addItemLancamento($parametros);

                    if (!empty($receita) && sizeof($receita) > 0) {
                        foreach ($receita as $item) {
//                            $prodReceita = Produto::find($item['cdproduto_filho']);

                            $parametros['cdproduto'] = $item['cdproduto_filho'];
                            $parametros['quantidade'] = $item['quantidade'] * $produto['quantidade'];

                            $parametros['precounitario'] = $produto['precounitario']/$item['quantidade'];

                            $this->addItemLancamento($parametros);
                        }
                    }

                }

                DB::commit();
                $return['resultado'] = true;
            } catch (\Exception $e) {
                DB::rollBack();
                $return['mensagem'] = $e->getMessage();
            }
        } else {
            $return['mensagem'] = 'Nenhum produto informado.';
        }

        return $return;
    }

    public function addItemLancamento($info) {
        $item = new ItemLancamento();
        $item->lancamento = $info['id'];
        $item->cdproduto = $info['cdproduto'];
        $item->quantidade = $info['quantidade'];
        $item->precounitario = $info['precounitario'];
        $item->id_ultatu = Auth::user()->id;
        $item->save();
    }

    public function getLancamento($id) {
        return Lancamento::with('itens')->find($id);
    }

    public function excluirLancamento(Request $request) {
        $resultado = array('resultado' => false);

        $validatedData = $request->validate([
            'id' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $lancamento = Lancamento::find($request->id);

            $lancamento->itens()->delete();

            $lancamento->delete();

            $resultado['resultado'] = true;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $resultado['resultado'] = false;
            $resultado['mensagem'] = $e->getMessage();
        }

        return $resultado;
    }
}
