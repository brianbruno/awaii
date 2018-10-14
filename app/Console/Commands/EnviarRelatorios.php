<?php

namespace App\Console\Commands;

use App\Http\Controllers\Relatorios\RelatorioLucroPorProduto;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Relatorios\RelatorioMovimentacaoEstoque;
use Illuminate\Console\Command;
use App\Mail\EnviarRelatorios as MailRelatorios;
use Illuminate\Support\Facades\Storage;

class EnviarRelatorios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enviar:relatorios';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia os relatorios de vendas que foram configurados pelo cliente.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Envio de e-mails para os clientes.');
        $relatorios = [];
        $relatorios[] = new RelatorioMovimentacaoEstoque();
        $relatorios[] = new RelatorioLucroPorProduto();
        $arquivos = [];

        $bar = $this->output->createProgressBar(sizeof($relatorios));
        // the finished part of the bar
        $bar->setBarCharacter('<comment>=</comment>');
        // the unfinished part of the bar
        $bar->setEmptyBarCharacter(' ');
        // the progress character
        $bar->setProgressCharacter('>');

        $bar->start();

        foreach ($relatorios as $relatorio) {
            $arquivos[] = $relatorio->gerarRelatorio();
            $bar->advance();
        }

        Mail::to('contact@brian.place')->send(new MailRelatorios($arquivos));

        foreach ($arquivos as $arquivo)
            Storage::delete($arquivo);

        $bar->finish();
        $this->info('');
        $this->info('Operacao Realizada!');
        $this->info('');
    }
}
