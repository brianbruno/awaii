<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ItemPedido;
use App\Cliente;

class Pedido extends Model {

    public function itens() {
        return $this->hasMany(ItemPedido::class, 'id_pedido', 'id');
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id');
    }

    public function getTotalAttribute($value) {
        $valor = 0;
        foreach ($this->itens()->get() as $item) {
            $valor = $valor + $item->original['total'];
        }
        return 'R$' . number_format($valor, 2, ',', '.');
    }

    public static function pedidosPendentes() {
        return Pedido::where('status', '<>', 'FINALIZADO')->count();
    }
}
