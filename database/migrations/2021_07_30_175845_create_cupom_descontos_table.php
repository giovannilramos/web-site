<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCupomDescontosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cupom_descontos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('localizador');
            $table->decimal('desconto');
            $table->decimal('limite');
            $table->enum('modo_limite',['valor','qtd']);
            $table->dateTime('dthr_validade');
            $table->enum('ativo',['s','n']);
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
        Schema::dropIfExists('cupom_descontos');
    }
}
