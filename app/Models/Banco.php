<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    use HasFactory;
    protected $table = "bancodehoras";
    protected $dates = ['data_ini','data_fim'];
    protected $fillable = [
        'justificativa',
        'tipo',
        'autor_id',
        'funcionario_id',
        'data_ini',
        'data_fim'
        ];

    public function funcionario(){
        return $this->hasOne(Funcionario::class,'matricula','funcionario_id');
    }

    public function autor(){
        return $this->hasOne(User::class,'id','autor_id');
    }
}
