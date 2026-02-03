<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produto;
use App\Models\Local;
use App\Models\TipoTransferencia;
use App\Models\User;

class Transferencia extends Model
{
    protected $fillable = [
        'tipo_id',
        'local_origem_id',
        'local_destino_id',
        'alojamento_id',
        'user_id',
        'status_id',
        'observacao'
    ];

    public function itens(){
        return $this->hasMany(TransferenciaItem::class);
    }

    public function status(){
        return $this->belongsTo(StatusOs::class, 'status_id');
    }

    public function alojamento(){
        return $this->belongsTo(Alojamento::class);
    }

    public function tipo(){
        return $this->belongsTo(TipoTransferencia::class, 'tipo_id');
    }

    public function origem(){
        return $this->belongsTo(Local::class, 'local_origem_id');
    }

    public function destino(){
        return $this->belongsTo(Local::class, 'local_destino_id');
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
