<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CupomDesconto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'localizador',
        'desconto',
        'limite',
        'modo_limite',
        'dthr_validade',
        'ativo',
        'modo_desconto'
    ];
}
