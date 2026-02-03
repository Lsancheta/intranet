<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $table = 'locais';

    protected $fillable= [
            'nome',
            'tipo',
            'alojamento_id'
    ];
    
    public function transferenciasOrigem()
    {
        return $this->hasMany(Transferencia::class, 'local_origem_id');
    }
    public function transferenciasDestino(){

        return $this->hasMany(Transferencia::class, 'local_destino_id');
    }
}
