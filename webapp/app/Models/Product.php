<?php

namespace App\Models;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    protected $table = 'produto';

    protected $fillable = [
        'nome',
        'descricao',
        'precoAtual',
        'desconto',
        'stock',
        'id_administrador'
    ];

    /**
     * Get the reviews for a product.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
