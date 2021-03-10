<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    use HasFactory;

    protected $table = 'setores';
    protected $fillable = [
        'nome',
        'jornada'
    ];

    public function colaboradores()
    {
        return $this->hasMany(User::class,'setor_id');
    }

}
