<?php

namespace App;

use App\Helpers\ModelMPK;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

    public static function getItensPedido($id, $unidade) {
        return DB::table('item_pedidos')
            ->select('item_pedidos.status', 'dt_pedido', 'pedidos.id as pedido_id', 'item_pedidos.quantidade',
                'produtos.cdproduto', 'produtos.nmproduto', 'item_pedidos.preco', 'produtos.unidade', DB::raw('item_pedidos.quantidade * item_pedidos.preco as total'))
            ->join('pedidos', 'pedidos.id', '=', 'item_pedidos.id_pedido')
            ->join('produtos', 'produtos.cdproduto', '=', 'item_pedidos.cdproduto')
            ->where('item_pedidos.unidade',  Auth::user()->unidade)
            ->where('pedidos.unidade', Auth::user()->unidade)
            ->where('pedidos.id', $id)->get();
    }
}
