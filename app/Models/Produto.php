<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'nome',
        'unidade',
        'preco_custo',
        'estoque_minimo',
        'ativo',
    ];

    public function itensTransferencias(){
        return $this->hasMany(TransferenciaItem::class, 'produto_id');
    }
}
