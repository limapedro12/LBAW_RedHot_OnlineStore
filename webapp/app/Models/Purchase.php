<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ProductPurchase;

class Purchase extends Model
{
    use HasFactory;

    protected $table = 'compra';
    public $timestamps = false;

    protected $fillable = [
        'timestamp',
        'total',
        'descricao',
        'id_utilizador',
        'estado',
        'id_administrador'
    ];

}
