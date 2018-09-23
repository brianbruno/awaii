<?php

namespace App\Exports;

use App\Pedido;
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

class PedidosExport implements FromView, ShouldAutoSize, WithEvents {


    /**
     * PedidosExport constructor.
     */
    public function __construct() {
        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });

        Writer::macro('setCreator', function (Writer $writer, string $creator) {
            $writer->getDelegate()->getProperties()->setCreator($creator);
        });
    }

    public function view(): View {
        return view('exports.pedidos', ['pedidos' => Pedido::all()]);
    }

    public function registerEvents(): array {
        return [
            BeforeExport::class  => function(BeforeExport $event) {
                $event->writer->setCreator(config('app.name', 'Awaii'));
            },
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->styleCells(
                    'A1:F1',
                    [
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'color'    => ['rgb' => 'c9c9c9']
                        ],
                        'font'  => [
                            'bold'  =>  true,
                            'size'  => '15'
                        ],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical'   => Alignment::VERTICAL_CENTER
                        ],
                    ]
                );

                $event->sheet->styleCells(
                    'A2:A500',
                    [
                        'font'  => [
                            'bold'  =>  true
                        ],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_CENTER
                        ],
                    ]
                );
            },
        ];
    }

}
