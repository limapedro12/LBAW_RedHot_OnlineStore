<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * Get the user that owns the card.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
