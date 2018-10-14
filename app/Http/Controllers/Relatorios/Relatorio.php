<?php

namespace App\Http\Controllers\Relatorios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class Relatorio extends Controller implements iRelatorio {

  public $nome = "Relatório";
  private $relatorio = [];

}
