<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'valor',
        'estoque',
        'url',
        'desc',
        'id_categorias'
    ];

    public function categoria() {
        return $this->belongsTo('App\Models\Categorias');
    }
}
