<?php

namespace App\Listeners;

use App\Events\PedidoRealizado;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnviarNotificacaoPedidoRealizado
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PedidoRealizado  $event
     * @return void
     */
    public function handle(PedidoRealizado $event)
    {
        //
    }
}
