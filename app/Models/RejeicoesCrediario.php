<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejeicoesCrediario extends Model
{
    use HasFactory;
    protected $table = 'rejeicoes_crediario';
    protected $fillable = [
        'motivo',
        'crediario_id',
    ];

    public function crediario()
    {
        return $this->belongsTo(Crediario::class, 'crediario_id', 'id');
    }
}
