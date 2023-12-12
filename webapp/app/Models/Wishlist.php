<?php

namespace App\Models;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = 'produtowishlist';

    protected $fillable = [
        'id',
        'id_utilizador',
        'id_produto'
    ];
}