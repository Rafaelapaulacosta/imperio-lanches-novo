<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lanche extends Model
{
    protected $fillable = [
        'nome',
        'descricao',
        'preco',
    ];

    protected $casts = [
        'preco' => 'decimal:2',
    ];
}
