<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Models\Product;

class ProductCart extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'produtocarrinho';

    protected $fillable = [
        'id',
        'id_produto',
        'id_utilizador',
        'quantidade',
        'id_utilizador_nao_autenticado'
    ];
}
