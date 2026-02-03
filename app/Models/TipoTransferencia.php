<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoTransferencia extends Model
{
    protected $table = 'tipos_transferencia';

    protected $fillable =['nome'];

    public function transferencias(){
        return $this->hasMany(Transferencia::class, 'tipo_id');
    }
}
