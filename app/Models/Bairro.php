<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bairro extends Model
{
        protected $fillable = [
        'nome',
        'valor_frete',
    ];

    protected $casts = [
        'valor_frete' => 'decimal:2',
    ];
}
