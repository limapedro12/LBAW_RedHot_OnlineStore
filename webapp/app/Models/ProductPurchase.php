<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPurchase extends Model
{
    use HasFactory;

    protected $table = 'produtocompra';
    public $timestamps  = false;

    protected $fillable = [
        'id_produto',
        'id_compra',
        'quantidade'
    ];
}
