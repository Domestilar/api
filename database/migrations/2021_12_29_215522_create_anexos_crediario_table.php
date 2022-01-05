<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnexosCrediarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anexos_crediario', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->string('url');
            $table->integer('crediario_id');
            $table->foreign('crediario_id')->references('id')->on('crediarios')->onDelete('CASCADE');
            $table->string('status')->default('VERIFICAÇÃO PENDENTE');
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
        Schema::dropIfExists('anexos_crediario');
    }
}
