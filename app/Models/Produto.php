<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = [
        'nome',
        'unidade',
        'tipo_id',
        'preco_custo',
        'estoque_minimo',
        'ativo',
    ];

    public function itensTransferencias(){
        return $this->hasMany(TransferenciaItem::class, 'produto_id');
    }

    public function tipo(){
        return $this->belongsTo(TipoProduto::class, 'tipo_id');
    }


     public function estoqueItems(){
        return $this->hasMany(EstoqueItem::class, 'produto_id');
    }

     public function depositoItems(){
        return $this->hasMany(DepositoItem::class, 'produto_id');
    }


}
