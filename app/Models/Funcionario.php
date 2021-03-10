<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricula',
        'nome',
        'data_nasc',
        'total_horas',
        'setor_id'
    ];

    public function setor(){
        return $this->hasOne(Setor::class,'id','setor_id');
    }
}
