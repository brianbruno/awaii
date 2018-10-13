<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 12/10/2018
 * Time: 23:51
 */

namespace App\Http\Controllers\Housekeeping\Relatorio;


use App\Produto;

class RelatorioController {

    public function lucroPorProduto() {
        return view('hk.relatorio.lucroporproduto', ['produtos' => Produto::where('tipo', 'V')->get()]);
    }
}
