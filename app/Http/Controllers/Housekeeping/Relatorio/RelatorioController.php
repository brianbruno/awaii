<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 12/10/2018
 * Time: 23:51
 */

namespace App\Http\Controllers\Housekeeping\Relatorio;


use App\Exports\LucroProdutoExport;
use App\Exports\MovimentacaoEstoqueExport;
use App\ItemLancamento;
use App\Produto;
use Maatwebsite\Excel\Facades\Excel;

class RelatorioController {

    public function lucroPorProduto() {
        return view('hk.relatorio.lucroporproduto', ['produtos' => Produto::where('tipo', 'V')->get()]);
    }

    public function lucroPorProdutoExport() {
        return Excel::download(new LucroProdutoExport(), 'Lucro por Produto - '.date('d-m-Y-Hi').'.xlsx');
    }

    public function movimentacaoEstoque() {
        return view('hk.relatorio.movimentacaoestoque', ['produtos' => ItemLancamento::getMovimentacaoEstoqueMes()]);
    }

    public function movimentacaoEstoqueExport() {
        return Excel::download(new MovimentacaoEstoqueExport(), 'Movimentação de Estoque - '.date('d-m-Y-Hi').'.xlsx');
    }
}
