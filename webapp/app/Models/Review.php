<?php

namespace App\Models;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = 'comentario';

    protected $fillable = [
        'timestamp',
        'texto',
        'avaliacao',
        'id_utilizador',
        'id_produto'
    ];

}
