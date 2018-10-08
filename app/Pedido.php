<?php

namespace App;

use App\Helpers\ModelMPK;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Facades\Auth;

class Pedido extends ModelMPK {

    protected $primaryKey = ['id', 'unidade'];
    public $incrementing = false;
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

    public static function getPedidosPendentes($unidade = '') {
        $unidade = Auth::user()->unidade;
        return DB::table('pedidos')
            ->select('clientes.nome as cliente_nome', 'clientes.telefone as cliente_telefone', 'pedidos.dt_pedido', DB::raw('DATE_FORMAT(pedidos.dt_pedido,\'%d/%m/%Y %H:%i:%s\') as dt_br'),
                            'pedidos.status', 'dt_pedido', 'unidades.id as unidade_id','unidades.nome as unidade_nome', 'pedidos.id as pedido_id',
                            DB::raw('sum(item_pedidos.total) as total'))
            ->join('clientes', 'pedidos.id_cliente', '=', 'clientes.id')
            ->join('unidades', 'pedidos.unidade', '=', 'unidades.id')
            ->join('item_pedidos', 'pedidos.id', '=', 'item_pedidos.id_pedido')
            ->where('item_pedidos.unidade',  $unidade)
            ->where('pedidos.status', '<>', 'FINALIZADO')
            ->where('pedidos.unidade', $unidade)
            ->groupBy('clientes.nome', 'clientes.telefone', 'pedidos.dt_pedido', 'pedidos.status', 'dt_pedido',
                               'unidades.nome', 'pedidos.id', 'unidades.id', 'pedidos.unidade')->get();
    }

    public static function getPedido($id, $unidade) {
        return DB::table('pedidos')
            ->select('clientes.nome as cliente_nome', 'clientes.telefone as cliente_telefone', 'pedidos.dt_pedido',
                'pedidos.status', 'dt_pedido', 'unidades.id as unidade_id','unidades.nome as unidade_nome', 'pedidos.id as pedido_id',
                DB::raw('sum(item_pedidos.total) as total'))
            ->join('clientes', 'pedidos.id_cliente', '=', 'clientes.id')
            ->join('unidades', 'pedidos.unidade', '=', 'unidades.id')
            ->join('item_pedidos', 'pedidos.id', '=', 'item_pedidos.id_pedido')
            ->where('item_pedidos.unidade',  $unidade)
            ->where('pedidos.unidade', $unidade)
            ->where('pedidos.id', $id)
            ->groupBy('clientes.nome', 'clientes.telefone', 'pedidos.dt_pedido', 'pedidos.status', 'dt_pedido',
                'unidades.nome', 'pedidos.id', 'unidades.id', 'pedidos.unidade')->first();
    }
}
