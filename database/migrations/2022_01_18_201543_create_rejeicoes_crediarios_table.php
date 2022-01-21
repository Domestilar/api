<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRejeicoesCrediariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rejeicoes_crediario', function (Blueprint $table) {
            $table->id();
            $table->string('motivo');
            $table->integer('crediario_id');
            $table->foreign('crediario_id')->references('id')->on('crediarios')->onDelete('CASCADE');
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
        Schema::dropIfExists('rejeicoes_crediario');
    }
}
