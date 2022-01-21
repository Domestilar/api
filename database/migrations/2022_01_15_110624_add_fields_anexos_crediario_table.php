<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsAnexosCrediarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anexos_crediario', function (Blueprint $table) {
            $table->string('motivo_rejeicao')->nullable();
            $table->boolean('notificado')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anexos_crediario', function (Blueprint $table) {
            $table->dropColumn('motivo_rejeicao');
            $table->dropColumn('notificado');
        });
    }
}
