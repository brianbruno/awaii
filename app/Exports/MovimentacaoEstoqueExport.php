<?php

namespace App\Exports;

use App\ItemLancamento;
use Illuminate\Contracts\View\View;

class MovimentacaoEstoqueExport extends ExportView {

    public function view(): View {
        return view('exports.movimentacaoestoque', ['produtos' => ItemLancamento::getMovimentacaoEstoqueMes()]);
    }

}
