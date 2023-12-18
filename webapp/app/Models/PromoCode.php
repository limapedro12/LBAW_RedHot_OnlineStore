<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Admin;

class PromoCode extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'promo_codes';

    protected $fillable = [
        'id',
        'codigo',
        'desconto',
        'data_inicio',
        'data_fim',
        'id_administrador'
    ];

    public function administrador()
    {
        return $this->belongsTo(Admin::class, 'id_administrador');
    }

    public function getAdministrador()
    {
        return $this->administrador()->get();
    }

    public function getAllPromoCodes()
    {
        return $this->all();
    }

    public function getNormalizePromoCodeId(int $id)
    {
        $highestId = PromoCode::max('id');
        $highestIdLength = strlen((string) $highestId);
        $id = (string) $id;
        $id = str_pad($id, ($highestIdLength + 1), '0', STR_PAD_LEFT);
        return $id;
    }
}