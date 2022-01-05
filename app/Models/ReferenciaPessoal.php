<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferenciaPessoal extends Model
{
    use HasFactory;
    protected $table = 'referencias_pessoais';
    protected $fillable = [
        'nome',
        'telefone',
        'ramal',
        'crediario_id'
    ];

    public function crediario()
    {
        return $this->belongsTo(Crediario::class, 'crediario_id', 'id');
    }
}
