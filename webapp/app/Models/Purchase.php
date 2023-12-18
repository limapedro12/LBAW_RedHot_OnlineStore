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
        'sub_total',
        'descricao',
        'id_utilizador',
        'estado',
        'id_administrador',
        'promo_code'
    ];

    public function getProducts()
    {
        return ProductPurchase::all()->where('id_compra', $this->id)->join('produto', 'produto.id');
    }

    public function getNormalizeOrderId(int $id)
    {

        $highestId = Order::max('id');
        $highestIdLength = strlen((string) $highestId);
        $id = (string) $id;
        $id = str_pad($id, ($highestIdLength + 1), '0', STR_PAD_LEFT);
        return $id;

    }

    public function getUserEmail(int $id){
        $user = User::find($id);
        return $user->email;
    }
}
