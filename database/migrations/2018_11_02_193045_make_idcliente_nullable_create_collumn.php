<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeIdclienteNullableCreateCollumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->integer('id_cliente')->unsigned()->nullable()->after('id');
            $table->foreign('id_cliente')->references('id')->on('clientes');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropForeign(['id_cliente']);
            $table->dropColumn('id_cliente');
        });
        Schema::table('pedidos', function (Blueprint $table) {
            $table->integer('id_cliente')->unsigned()->after('id');
            $table->foreign('id_cliente')->references('id')->on('clientes');
        });

    }
}
