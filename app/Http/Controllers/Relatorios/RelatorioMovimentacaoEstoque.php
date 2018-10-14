<?php
/**
 * Created by IntelliJ IDEA.
 * User: brian
 * Date: 14/10/2018
 * Time: 11:45
 */

namespace App\Http\Controllers\Relatorios;


use App\Exports\MovimentacaoEstoqueExport;
use App\Http\Controllers\Housekeeping\Relatorio\RelatorioController;
use App\Mail\EnviarRelatorios;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class RelatorioMovimentacaoEstoque extends Relatorio {

    public $nome = "Relatório de Movimentação de Estoque";
    public $fileName = '';

    public function gerarRelatorio() {
        $this->fileName = 'Movimentação de Estoque - '.time().'.xlsx';
        Excel::store(new MovimentacaoEstoqueExport(), $this->fileName);
        return $this->fileName;
    }

    public function enviarRelatorio() {
        Mail::to('contact@brian.place')->send(new EnviarRelatorios([$this->fileName]));
        Storage::delete($this->fileName);
    }
}
