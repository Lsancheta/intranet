<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'nome',
        'categoria',
        'descricao'
    ];

    public function transferencias(){
        return $this->hasMany(Transferencia::class);
    }
}
