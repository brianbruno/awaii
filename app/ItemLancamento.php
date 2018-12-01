<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ItemLancamento extends Model {

    protected $appends = ['nmproduto', 'precof', 'unidadeLabel'];

    public function lancamento() {
        return $this->belongsTo(Lancamento::class, 'lancamento', 'id');
    }

    public function produto() {
        return $this->hasOne(Produto::class, 'cdproduto', 'cdproduto');
    }

    public function getNmprodutoAttribute() {
        return $this->produto()->get()[0]->nmproduto;
    }

    public function getUnidadeLabelAttribute() {
        return $this->produto()->get()[0]->getUnidadeLabelAttribute();
    }

    public function getPrecofAttribute() {
        return 'R$' . number_format($this->precounitario, 5, ',', '.');
    }

    public function getValorMedioCusto() {
        $custo = DB::table('item_lancamentos')
            ->select(DB::raw('avg(item_lancamentos.precounitario) as precocusto'))
            ->join('produtos', 'produtos.cdproduto', '=', 'item_lancamentos.cdproduto')
            ->join('lancamentos', 'item_lancamentos.lancamento', '=', 'lancamentos.id')
            ->where('produtos.cdproduto', $this->produto()->get()[0]->cdproduto)
            ->whereDate('dt_lancamento', '>', Carbon::now()->subDays(30)->toDateTimeString())->first();

        if (!empty($custo))
            $vrCusto = $custo->precocusto;
        else
            $vrCusto = 0;

        return $vrCusto;

    }

    public static function getMovimentacaoEstoqueMes(){
        return DB::table('item_lancamentos')
            ->select('produtos.cdproduto', 'produtos.nmproduto', 'lancamentos.id', DB::raw('DATE_FORMAT(lancamentos.dt_lancamento,\'%d/%m/%Y %H:%i:%s\') as dt_br'),
                'item_lancamentos.quantidade', 'item_lancamentos.precounitario')
            ->join('produtos', 'produtos.cdproduto', '=', 'item_lancamentos.cdproduto')
            ->join('lancamentos', 'item_lancamentos.lancamento', '=', 'lancamentos.id')
            ->whereDate('dt_lancamento', '>', Carbon::now()->subDays(30)->toDateTimeString())->get();
    }

}
