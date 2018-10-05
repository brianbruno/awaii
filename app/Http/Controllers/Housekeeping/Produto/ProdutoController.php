<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 22/09/2018
 * Time: 17:43
 */

namespace App\Http\Controllers\Housekeeping\Produto;

use App\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdutoController {

    public  function index () {

        return view('hk.produto.index', ['produtos' => Produto::all()]);
    }

    public function cadastrar (Request $request) {

        $validatedData = $request->validate([
            'cdproduto' => 'required|unique:produtos|max:10',
            'nmproduto' => 'required|max:100',
            'preco' => 'required|numeric',
        ]);

        $produto = new Produto();

        $produto->cdproduto = $request->cdproduto;
        $produto->nmproduto = $request->nmproduto;
        $produto->unidade = Auth::user()->unidade;
        $produto->preco = $request->preco;


        $produto->save();

        return view('hk.produto.cadastrar-produto', ['resultado' => true]);
    }
}
