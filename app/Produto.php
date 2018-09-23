<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model {

    protected $primaryKey = 'cdproduto';
    public $incrementing = false;

    public function getPrecofAttribute($value) {
        return 'R$' . number_format($this->preco, 2, ',', '.');
    }
}
