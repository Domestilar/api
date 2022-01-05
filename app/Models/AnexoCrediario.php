<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnexoCrediario extends Model
{
    use HasFactory;
    protected $table = 'anexos_crediario';
    protected $fillable = ['tipo', 'url', 'crediario_id', 'status'];

    public function crediario()
    {
        return $this->belongsTo(Crediario::class, 'id', 'crediario_id');
    }
}
