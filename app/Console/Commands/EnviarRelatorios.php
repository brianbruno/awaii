<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Relatorios\RelatorioPedidos;

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
        $relatorios[]  = new RelatorioPedidos();
      
        $bar = $this->output->createProgressBar(sizeof($relatorios));
        // the finished part of the bar
        $bar->setBarCharacter('<comment>=</comment>');
        // the unfinished part of the bar
        $bar->setEmptyBarCharacter(' ');
        // the progress character
        $bar->setProgressCharacter('>');
        
        $bar->start();
      
        foreach ($relatorios as $relatorio) {
          $relatorio->gerarRelatorio();
          $relatorio->enviarRelatorio();
          $bar->advance();
        }
        $bar->finish();
        $this->info('');
        $this->info('Operacao Realizada!');
        $this->info('');
    }
}
