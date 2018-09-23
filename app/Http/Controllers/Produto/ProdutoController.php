<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 22/09/2018
 * Time: 17:43
 */

namespace App\Http\Controllers\Produto;


use App\Produto;
use Illuminate\Http\Request;

class ProdutoController {

    public  function index () {

        return view('system.produto.index', ['produtos' => Produto::all()]);
    }

    public function cadastrar (Request $request) {

        $validatedData = $request->validate([
            'cdproduto' => 'required|unique:produtos|max:10',
            'nmproduto' => 'required|max:100',
            'unidade' => 'required',
            'preco' => 'required|numeric',
        ]);

        $produto = new Produto();

        $produto->cdproduto = $request->cdproduto;
        $produto->nmproduto = $request->nmproduto;
        $produto->unidade = $request->unidade;
        $produto->preco = $request->preco;


        $produto->save();

        return view('system.produto.cadastrar-produto', ['resultado' => true]);
    }
}
