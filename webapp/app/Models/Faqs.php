<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Admin;

class Faqs extends Model
{
    use HasFactory;

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
}