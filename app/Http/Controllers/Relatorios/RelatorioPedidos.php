<?php

namespace App\Http\Controllers\Relatorios;

use App\Pedido;

class RelatorioPedidos extends Relatorio {
    
  public $nome = "Relatório de Pedidos";
  
  public function gerarRelatorio() {
    $pedidos = Pedido::with('item_pedidos')->get()->toArray();
    var_dump($pedidos);die;
  }
  
  public function enviarRelatorio() {
    
  }
  
}
