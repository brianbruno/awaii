<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model {

    public function organizacaco() {
        return $this->belongsTo(User::class, 'id', 'org');
    }

    public function usuarios() {
        return $this->belongsTo(User::class, 'id', 'unidade');
    }

    public function getDtvalidadeAttribute($value) {
        if (!empty($this->validade_licenca)) {
            return date('d/m/Y H:i:s', strtotime($this->validade_licenca));
        } else {
            return '';
        }
    }
}
