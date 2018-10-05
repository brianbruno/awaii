<?php

namespace App;

use App\Helpers\ModelMPK;

class Pedido extends ModelMPK {

    protected $primaryKey = ['id', 'unidade'];

    /**
     * IDPEDIDO + IDUNIDADE
     */
    const CONTADOR = 'IDPEDIDO';

    public function itens() {
        return $this->hasMany(ItemPedido::class, 'id_pedido', 'id');
    }

    public function unidade() {
        return $this->belongsTo(Cliente::class, 'unidade', 'id');
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

    public static function pedidosPendentes($unidade) {
        return Pedido::where('status', '<>', 'FINALIZADO')
                      ->where('unidade', $unidade)->count();
    }
}
