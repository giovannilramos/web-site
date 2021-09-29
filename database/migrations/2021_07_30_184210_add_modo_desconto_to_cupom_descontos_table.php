<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModoDescontoToCupomDescontosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cupom_descontos', function (Blueprint $table) {
            $table->enum('modo_desconto',['valor','porc'])->default('porc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cupom_descontos', function (Blueprint $table) {
            $table->dropColumn('modo_desconto');
        });
    }
}
