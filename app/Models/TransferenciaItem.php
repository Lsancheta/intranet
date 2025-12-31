<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferenciaItem extends Model
{
    protected $table = 'transferencia_itens';

    protected $fillable = [
        'transferencia_id',
        'produto_id',
        'quantidade',
    ];

    public function transferencia(){
        return $this->belongsTo(Transferencia::class);
    }

    public function produto(){
        return $this->belongsTo(Produto::class);
    }
}
