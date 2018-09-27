<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToItempedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_pedidos', function (Blueprint $table) {
            $table->enum('status',['CRIADO', 'PRODUCAO', 'PRODUZIDO', 'ENTREGUE'])
                ->default('CRIADO')
                ->after('cdproduto')
                ->comment('Status do produto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_pedidos', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
