<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryToProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema vem na tabela colocada na criação da migration 
        Schema::table('produtos', function (Blueprint $table) {
            //Adicione o campo que precisa alterar na tabela ex
            //$table->string('cpf')
            //depois faça um php artisan migrate
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
            //$table->dropColumn('nome do campo');
        });
    }
}
