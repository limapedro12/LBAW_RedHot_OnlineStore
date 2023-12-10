<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'compra';

    protected $fillable = [
        'id',
        'timestamp',
        'total',
        'descricao',
        'id_utilizador',
        'estado',
        'id_administrador'
    ];

}