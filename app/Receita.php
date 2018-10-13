<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receita extends Model {

    protected $appends = ['nomepai', 'nomefilho', 'unidadefilho', 'unidadeLabel', 'precocustof', 'precocustocomposicao', 'precocustocomposicaof'];

    public function produto() {
        return $this->belongsTo(Produto::class, 'cdproduto_filho', 'cdproduto');
    }

    public function produtopai() {
        return $this->belongsTo(Produto::class, 'cdproduto', 'cdproduto');
    }

    public function getNomepaiAttribute() {
        return $this->produtopai()->get()[0]->nmproduto;
    }

    public function getNomefilhoAttribute() {
        return $this->produto()->get()[0]->nmproduto;
    }

    public function getUnidadefilhoAttribute() {
        return $this->produto()->get()[0]->unidade;
    }

    public function getUnidadeLabelAttribute() {
        return $this->produto()->get()[0]->unidadeLabel;
    }

    public function getPrecocustofAttribute() {
        return $this->produto()->get()[0]->precocustof;
    }


    public function getPrecocustocomposicaoAttribute() {
        $custo = $this->quantidade * $this->produto()->get()[0]->precocusto;
        return $custo;
    }

    public function getPrecocustocomposicaofAttribute() {
        return 'R$ ' . number_format($this->precocustocomposicao, 5, ',', '.');
    }

}
