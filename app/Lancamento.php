<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Lancamento extends Model {

    protected $appends = ['itensLancamento', 'tipoLabel', 'dtlancamentof'];

    public function itens() {
        return $this->hasMany(ItemLancamento::class, 'lancamento', 'id');
    }

    public static function getUltimasMovimentacoes() {
        $unidade = Auth::user()->unidade;
        return DB::table('lancamentos')
            ->select('id', 'tipo', DB::raw('DATE_FORMAT(dt_lancamento,\'%d/%m/%Y %H:%i:%s\') as dt_br'))
            ->limit(15)->latest()->get();
    }

    public function getItensLancamentoAttribute() {
        return $this->itens()->count();
    }

    public function getTipoLabelAttribute() {
        return $this->tipo  == 'S' ? 'Saída' : 'Entrada';
    }

    public function getDtlancamentofAttribute() {
        return date('d/m/Y H:i:s', strtotime($this->dt_lancamento));
    }

}
