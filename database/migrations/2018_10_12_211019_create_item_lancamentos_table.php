<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemLancamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_lancamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lancamento')->unsigned();
            $table->string('cdproduto',10);
            $table->double('quantidade', 10, 2);
            $table->double('precounitario', 10, 2);
            $table->integer('id_ultatu')->unsigned()->nullable();
            $table->foreign('id_ultatu')->references('id')->on('users');
            $table->foreign('cdproduto')->references('cdproduto')->on('produtos');
            $table->foreign('lancamento')->references('id')->on('lancamentos');
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
        Schema::dropIfExists('item_lancamentos');
    }
}
