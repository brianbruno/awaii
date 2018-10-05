<?php

namespace App;

use App\Helpers\ModelMPK;

class ItemPedido extends ModelMPK {

    protected $hidden = ['id_pedido'];
    protected $primaryKey = ['id_pedido', 'sequencial', 'unidade'];
    public $incrementing = false;
    protected $appends = ['data'];

    public function pedido() {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id');
    }

    public function unidade() {
        return $this->belongsTo(Unidade::class, 'unidade', 'id');
    }

    public function produto() {
        return $this->hasOne(Produto::class, 'cdproduto', 'cdproduto');
    }

    public function getPrecoAttribute($value) {
        return 'R$' . number_format($value, 2, ',', '.');
    }

    public function getTotalAttribute($value) {
        return 'R$' . number_format($value, 2, ',', '.');
    }

    public function getDataAttribute($value) {
        return date('d/m/Y H:i:s', strtotime($this->dtpedido));
    }

    public static function getProducaoPendente() {
        return ItemPedido::where('status', '<>', 'ENTREGUE')
                         ->where('status', '<>', 'PRODUZIDO')->get();
    }
}
