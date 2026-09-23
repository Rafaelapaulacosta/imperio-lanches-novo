<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente',
        'forma_pagamento',
        'status',
        'valor_total',
        'observacao',
    ];

    public function itens()
    {
        return $this->hasMany(PedidoItem::class);
    }
}
