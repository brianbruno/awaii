<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model {

    public function usuarios() {
        return $this->belongsTo(User::class, 'id', 'unidade');
    }
}
