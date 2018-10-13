<?php

namespace App\Exports;

use App\Produto;
use \Maatwebsite\Excel\Sheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use \Maatwebsite\Excel\Writer;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class LucroProdutoExport extends ExportView {

    public function view(): View {
        return view('exports.lucroporproduto', ['produtos' => Produto::where('tipo', 'V')->get()]);
    }
}
