<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receitas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cdproduto',10);
            $table->string('cdproduto_filho',10);
            $table->double('quantidade', 10, 2)->comment('Em gramas/mililitros');
            $table->foreign('cdproduto')->references('cdproduto')->on('produtos');
            $table->foreign('cdproduto_filho')->references('cdproduto')->on('produtos');
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
        Schema::dropIfExists('receitas');
    }
}
