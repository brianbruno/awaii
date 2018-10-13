<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLancamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lancamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unidade')->unsigned();
            $table->enum('tipo',['E', 'S'])
                ->default('E')
                ->comment('E - Entrada S - Saida');
            $table->timestamp('dt_lancamento')->useCurrent();
            $table->integer('id_ultatu')->unsigned()->nullable();
            $table->foreign('id_ultatu')->references('id')->on('users');
            $table->foreign('unidade')->references('id')->on('unidades');
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
        Schema::dropIfExists('lancamentos');
    }
}
