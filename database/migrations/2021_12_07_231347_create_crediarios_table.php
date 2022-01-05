<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrediariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crediarios', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable();
            $table->string('nome');
            $table->string('cpf_cnpj',20);
            $table->string('rg')->nullable();
            $table->string('orgao_emissor_rg')->nullable();
            $table->date('data_emissao_rg')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('nome_conjuge')->nullable();
            $table->string('email', 50);
            $table->date('data_nascimento');
            $table->string('telefone', 16)->nullable();
            $table->string('celular', 16);
            $table->string('foto_selfie_url');
            $table->string('categoria_profissional');
            $table->string('profissao')->nullable();
            $table->string('sexo', 40)->nullable();
            $table->string('nome_pai')->nullable();
            $table->string('nome_mae')->nullable();
            $table->string('escolaridade', 40)->nullable();
            $table->string('logradouro', 100)->nullable();
            $table->string('numero', 6)->nullable();
            $table->string('complemento', 70)->nullable();
            $table->string('bairro', 70)->nullable();
            $table->string('cep', 11)->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado', 3)->nullable();
            $table->string('tipo_residencia', 50)->nullable();
            $table->string('tipo_comprovante_residencia', 50)->nullable();
            $table->string('nome_empresa')->nullable();
            $table->string('logradouro_empresa', 100)->nullable();
            $table->string('numero_empresa', 6)->nullable();
            $table->string('complemento_empresa', 70)->nullable();
            $table->string('bairro_empresa', 70)->nullable();
            $table->string('cidade_empresa', 50)->nullable();
            $table->string('cep_empresa', 11)->nullable();
            $table->string('estado_empresa', 3)->nullable();
            $table->string('telefone_empresa', 16)->nullable();
            $table->string('celular_empresa', 16)->nullable();
            $table->string('email_empresa', 50)->nullable();
            $table->string('cnpj_empresa', 16)->nullable();
            $table->string('natureza_ocupacao_empresa', 50)->nullable();
            $table->string('tipo_comprovante_renda_empresa', 50)->nullable();
            $table->date('data_admissao_empresa')->nullable();
            $table->string('status')->default('AGUARDANDO VALIDAÇÃO');
            $table->softDeletes();
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
        Schema::dropIfExists('crediarios');
    }
}
