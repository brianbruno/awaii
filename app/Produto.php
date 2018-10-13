<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Produto extends Model {

    protected $primaryKey = 'cdproduto';
    public $incrementing = false;
    protected $appends = ['precof', 'unidadeLabel', 'precocusto', 'precocustof', 'taxalucro', 'taxalucrof'];

    public function getPrecofAttribute($value) {
        return 'R$ ' . number_format($this->preco, 2, ',', '.');
    }

    public function getPrecocustoAttribute() {
        $receita = $this->receita()->get();
        $soma = 0;

        if (!empty($receita) && sizeof($receita) > 0) {
            foreach ($receita as $item) {
                $soma += $item->produto()->first()->getPrecocustoAttribute() * $item->quantidade;
            }
        } else {
            $itemLancamento = $this->itemLancamento()->first();
            if (!empty($itemLancamento)) {
                $soma = $itemLancamento->getValorMedioCusto();
            }
        }

        return $soma;
    }

    public function getUnidadeLabelAttribute() {
        $unidades = array(
            'KG' => 'Quilos',
            'G'  => 'Gramas',
            'UN' => 'Unidade',
            'ML' => 'Mililitros'
        );

        return $unidades[$this->unidade];
    }

    public function receita() {
        return $this->hasMany(Receita::class, 'cdproduto', 'cdproduto');
    }

    public function itemLancamento() {
        return $this->belongsTo(ItemLancamento::class, 'cdproduto', 'cdproduto');
    }

    public function getPrecocustofAttribute() {
        return 'R$ ' . number_format($this->precocusto, 5, ',', '.');
    }

    public function getTaxalucroAttribute() {
        return $this->preco - $this->precocusto;
    }

    public function getTaxalucrofAttribute() {
        return 'R$ ' . number_format($this->taxalucro, 2, ',', '.');
    }
}
