<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoprodutoToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->decimal('preco', 10, 2)->nullable()->change();
            $table->enum('tipo', ['V', 'C'])->default('V')->comment('V - Venda C - Compra')->after('unidade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->double('preco', 10, 2)->nullable(false)->change();
            $table->dropColumn('tipo');
        });
    }
}
