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

        if ($request->user()->level < 7) {
            $unidade = $request->user()->unidade()->get();

            if (!empty($unidade[0])) {
                $unidade = $unidade[0];

                if (empty($unidade->validade_licenca) || strtotime($unidade->validade_licenca) < strtotime(date('Y-M-d H:i:s')) ) {
                    return redirect('1002');
                }
            } else {
                return redirect('1002');
            }



            if (!$request->user()->podeAcessar($request)) {
                return redirect('1001');
            }
        }



        return $next($request);
    }
}
