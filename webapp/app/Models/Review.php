<?php

namespace App\Models;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    protected $table = 'comentario';

    protected $fillable = [
        'timestamp',
        'texto',
        'avaliacao',
        'id_utilizador',
        'id_produto',
        'editado'
    ];

    public function getUserProfileImgById(int $id){
        $user = User::find($id);
        return $user->getProfileImage();
    }

    public function getUserNameById(int $id){
        $user = User::find($id);
        return $user->nome;
    }

    public function getHowLongTheCommentWas(int $id){

        $comment = Review::find($id);
        $date = $comment->timestamp;
        $date = strtotime($date);
        $date = date('Y-m-d H:i:s', $date);
        $date = new \DateTime($date);
        $now = new \DateTime();
        $diff = $now->diff($date);
        if($diff->y > 0){
            return $diff->y . " ano(s)";
        }else if($diff->m > 0){
            return $diff->m . " mês(es)";
        }else if($diff->d > 0){
            return $diff->d . " dia(s)";
        }else if($diff->h > 0){
            return $diff->h . " hora(s)";
        }else if($diff->i > 0){
            return $diff->i . " minuto(s)";
        }else if($diff->s > 0){
            return $diff->s . " segundo(s)";
        }
    }

    public function getProductNameById(int $id){
        $product = Product::find($id);
        return $product->nome;
    }

}
