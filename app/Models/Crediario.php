<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuid;

class Crediario extends Model
{
    use Uuid, HasFactory, softDeletes;
    protected $table = 'crediarios';
    protected $fillable = [
        'nome',
        'cpf_cnpj',
        'rg',
        'orgao_emissor_rg',
        'data_emissao_rg',
        'estado_civil',
        'nome_conjuge',
        'email',
        'data_nascimento',
        'telefone',
        'celular',
        'foto_selfie_url',
        'categoria_profissional',
        'profissao',
        'sexo',
        'nome_pai',
        'nome_mae',
        'escolaridade',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cep',
        'cidade',
        'estado',
        'tipo_residencia',
        'tipo_comprovante_residencia',
        'nome_empresa',
        'logradouro_empresa',
        'numero_empresa',
        'complemento_empresa',
        'bairro_empresa',
        'cidade_empresa',
        'cep_empresa',
        'estado_empresa',
        'telefone_empresa',
        'celular_empresa',
        'email_empresa',
        'cnpj_empresa',
        'natureza_ocupacao_empresa',
        'tipo_comprovante_renda_empresa',
        'data_admissao_empresa',
        'status',
        'motivo_rejeicao',
        'status',
        'validado'
    ];

    public function referenciasPessoais()
    {
        return $this->hasMany(ReferenciaPessoal::class, 'crediario_id', 'id');
    }

    public function anexos()
    {
        return $this->hasMany(AnexoCrediario::class, 'crediario_id', 'id');
    }

    public function rejeicoes()
    {
        return $this->hasMany(RejeicoesCrediario::class, 'crediario_id', 'id');
    }
}
