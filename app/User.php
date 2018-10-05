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

    public function user() {
        return $this->hasMany(User::class, 'unidade', 'id');
    }

    public function podeAcessar(Request $request) {
        $uri = $request->path();

        return $this->podeAcessarPagina($uri);
    }

    public function podeAcessarPagina($uri) {
        $level = $this->level;
        $paths = explode('/', $uri);

        $result = false;

        $permissoes = array(
            '' => '*',
            'home' => [1, 2, 3, 4, 5],
            'pedido' => [1, 2, 3, 4, 5],
            'producao' => [1, 2, 3, 4, 5],
            'housekeeping' => [6],
            'management' => [7]
        );

        if (isset($permissoes[$paths[0]])) {
            if ($permissoes[$paths[0]] == '*' || in_array($level, $permissoes[$paths[0]])) {
                $result = true;
            }
        } else {
            $result = true;
        }

        return $result;
    }
}
