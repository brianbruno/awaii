<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 22/09/2018
 * Time: 17:43
 */

namespace App\Http\Controllers\Housekeeping\Produto;

use App\Produto;
use App\Receita;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProdutoController {

    public  function index () {
        return view('hk.produto.index', ['produtos' => Produto::all()]);
    }

    public function getProdutosJson(Request $request) {

        $tipo = $request->tipo;

        if (empty($tipo))
            $retorno = Produto::all();
        else
            $retorno = Produto::where('tipo', '=', $tipo)->get();

        return $retorno;
    }

    public function getProdutoJson($cdproduto) {
        return Produto::with('receita')->find($cdproduto);
    }

    public function indexEditar($id) {
        $produto = Produto::with('receita')->find($id);
        return view('hk.produto.editar-produto', ['produto' => $produto]);
    }

    public function cadastrar (Request $request) {

        $add = $this->addProduto($request);

        return view('hk.produto.cadastrar-produto', $add);
    }

    public function addProduto(Request $request) {

        $validatedData = $request->validate([
            'cdproduto' => 'required|unique:produtos|max:10',
            'nmproduto' => 'required|max:100',
            'unidade' => 'required|max:2',
        ]);

        $produto = new Produto();
        $produto->cdproduto = $request->cdproduto;
        return $this->produtoAlter($request, $produto);
    }

    public function addReceita(Request $request) {
        $validatedData = $request->validate([
            'cdproduto' => 'required|max:10',
            'cdproduto_filho' => 'required|max:10',
            'quantidade' => 'required|numeric',
        ]);

        $resultado = true;

        try {
            $receita = new Receita();

            $receita->cdproduto = $request->cdproduto;
            $receita->cdproduto_filho = $request->cdproduto_filho;
            $receita->quantidade = $request->quantidade;

            $receita->save();
        } catch (\Exception $e) {
            $resultado = false;
        }

        return array('resultado' => $resultado);
    }

    public function editProduto(Request $request) {
        $produto = Produto::find($request->cdproduto);

        $validatedData = $request->validate([
            'cdproduto' => 'required|max:10',
            'nmproduto' => 'required|max:100',
            'unidade' => 'required|max:2',
        ]);

        if (!empty($produto)) {
            $return = $this->produtoAlter($request, $produto);
        } else {
            $return = array('resultado' => false, 'mensagem' => 'Produto não encontrado');
        }

        return $return;
    }

    public function produtoAlter(Request $request, Produto $produto) {

        $resultado = array('resultado' => true);

        try {
            $produto->nmproduto = $request->nmproduto;
            $produto->unidade = $request->unidade;
            $produto->preco = $request->preco;
            $produto->tipo = $request->tipo;

            $produto->save();
        } catch (\Exception $e) {
            $resultado['resultado'] = false;
            $resultado['mensagem'] = $e->getMessage();
        }

        return $resultado;
    }

    public function excluirComposicaoProduto(Request $request) {
        $resultado = array('resultado' => false);

        $validatedData = $request->validate([
            'id' => 'required'
        ]);

        try {
            $receita = Receita::find($request->id);

            $receita->delete();

            $resultado['resultado'] = true;
        } catch (\Exception $e) {
            $resultado['resultado'] = false;
            $resultado['mensagem'] = $e->getMessage();
        }

        return $resultado;
    }

    public function getProdutosCaixa() {
        $produtos = Produto::where('tipo', '=', 'V')->get();

        $tela = array();
        $nrProd = 0; // Contador do produto
        $nrTela = 0; // Contador da tela

        foreach ($produtos as $produto) {

            $tela[$nrTela]['produtos'][] = array(
                'nome'          => $produto->nmproduto,
                'cdproduto'     => $produto->cdproduto,
                'precounitario' => (float) $produto->preco,
                'style'         => array('background-color' => '#e2deba')
            );

            $nrProd++;
            if ($nrProd == 4) {
                $tela[] = array(
                    'produtos' => array()
                );
                $nrTela++;
            }
        }

        return $tela;
    }
}
