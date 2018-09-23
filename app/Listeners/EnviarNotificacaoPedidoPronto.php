<?php

namespace App\Listeners;

use App\Events\PedidoEntregue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnviarNotificacaoPedidoPronto
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PedidoEntregue  $event
     * @return void
     */
    public function handle(PedidoEntregue $event) {
        //
    }
}
