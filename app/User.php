<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function unidade() {
        return $this->hasOne(Unidade::class, 'id', 'unidade');
    }


    public function podeAcessar(Request $request) {
        $uri = $request->path();

        return $this->podeAcessarPagina($uri);
    }

    public function podeAcessarPagina($uri) {
        $level = $this->level;
        $unidade = $this->unidade;

        $result = false;

        $permissoes = array(
            '/' => '*',
            'home' => '*',
            'pedido' => [2, 3, 4, 5, 6, 7],
            'producao' => [2, 3, 4, 5, 6, 7],
            'housekeeping' => ['7']
        );

        if (isset($permissoes[$uri])) {
            if ($permissoes[$uri] == '*' || in_array($level, $permissoes[$uri])) {
                $result = true;
            }
        } else {
            $result = true;
        }

        return $result;
    }
}
