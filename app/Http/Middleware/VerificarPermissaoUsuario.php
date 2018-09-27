<?php

namespace App\Http\Middleware;

use Closure;

class VerificarPermissaoUsuario
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (empty($request->user()->unidade) && !$request->is('housekeeping') && !$request->is('housekeeping/*')) {
            return redirect('novo');
        }

        if (!$request->user()->podeAcessar($request)) {
            return redirect('1001');
        }


        return $next($request);
    }
}
