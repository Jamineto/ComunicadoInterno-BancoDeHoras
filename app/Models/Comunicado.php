<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunicado extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'assunto',
        'autor_id',
        'conteudo',
        'ativo',
        'origem_id',
        'destino_id',
        'apagado_id',
        'created_at',
        'updated_at'
    ];

    public function autor(){
        return $this->hasOne(User::class,'id','autor_id');
    }

    public function categoriaa(){
        return $this->hasOne(Categoria::class,'id','categoria');
    }

    public function visualizados(){
        return $this->belongsToMany(User::class,'visualizados');
    }

    public function destino(){
        return $this->hasOne(Setor::class,'id','destino_id');
    }

    public function origem(){
        return$this->hasOne(Setor::class,'id','origem_id');
    }

}
