<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NovoCodigo extends Model {

    protected $primaryKey = 'contador';
    protected $fillable = ['contador'];
    protected $table = 'novo_codigo';
    public $incrementing = false;

    public function getProxCodigo() {
        $this->valor = $this->valor + 1;
        $this->save();
        return $this->valor;
    }

    public static function retrieve($contador) {
        $novo = NovoCodigo::find($contador);
        $return = null;

        if (empty($novo)) {
            $novoCodigo = new NovoCodigo();
            $novoCodigo->contador = $contador;
            $novoCodigo->save();
            $return = $novoCodigo;
        } else {
            $return = $novo;
        }

        return $return;
    }
}
