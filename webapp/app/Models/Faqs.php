<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Admin;

class Faqs extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps = false;

    protected $table = 'faqs';

    protected $fillable = [
        'id',
        'pergunta',
        'resposta',
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

    public function getAllFaqs()
    {
        return $this->all();
    }

    public function getNormalizeFaqId(int $id)
    {
        $highestId = Faqs::max('id');
        $highestIdLength = strlen((string) $highestId);
        $id = (string) $id;
        $id = str_pad($id, ($highestIdLength + 1), '0', STR_PAD_LEFT);
        return $id;
    }
}