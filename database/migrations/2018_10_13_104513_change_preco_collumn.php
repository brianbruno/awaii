<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePrecoCollumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_lancamentos', function (Blueprint $table) {
            $table->decimal('precounitario', 50, 8)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_lancamentos', function (Blueprint $table) {
            $table->decimal('precounitario', 10, 2)->change();
        });
    }
}
