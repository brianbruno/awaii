<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->integer('id_cliente')->unsigned();
            $table->enum('status',['FINALIZADO', 'CRIADO', 'ANDAMENTO', 'CANCELADO'])
                ->default('CRIADO')
                ->comment('Status do pedido');
            $table->timestamp('dt_pedido')->useCurrent();
            $table->integer('unidade')->unsigned();
            $table->integer('id_ultatu')->unsigned();
            $table->foreign('id_ultatu')->references('id')->on('users');
            $table->foreign('unidade')->references('id')->on('unidades');
            $table->foreign('id_cliente')->references('id')->on('clientes');
            $table->primary(['id', 'unidade']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
