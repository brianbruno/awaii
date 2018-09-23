<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Pedido;

class Cliente extends Model
{
    public function pedido() {
        return $this->hasMany(Pedido::class, 'id_cliente', 'id');
    }
}
