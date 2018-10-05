<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_pedidos', function (Blueprint $table) {
            $table->integer('id_pedido')->unsigned();
            $table->integer('sequencial')->unsigned();
            $table->string('cdproduto',10);
            $table->integer('quantidade');
            $table->double('preco', 10, 2);
            $table->double('total', 10, 2);
            $table->enum('status',['CRIADO', 'PRODUCAO', 'PRODUZIDO', 'ENTREGUE'])
                ->default('CRIADO')
                ->comment('Status do produto');
            $table->timestamp('dtpedido')->useCurrent();
            $table->integer('unidade')->unsigned();
            $table->foreign('unidade')->references('id')->on('unidades');
            $table->foreign('cdproduto')->references('cdproduto')->on('produtos');
            $table->foreign('id_pedido')->references('id')->on('pedidos');
            $table->primary(['id_pedido', 'sequencial', 'unidade']);
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
        Schema::dropIfExists('item_pedidos');
    }
}
