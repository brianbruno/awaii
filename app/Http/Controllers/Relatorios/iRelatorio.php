<?php
namespace App\Http\Controllers\Relatorios;

interface iRelatorio {
  
    public function gerarRelatorio();
    public function enviarRelatorio();
  
}