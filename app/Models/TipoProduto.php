<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoProduto extends Model
{
    protected $table = 'tipos_produtos';
    
    public function produtos(){
        return $this->hasMany(Produto::class, 'tipo_id');
    }
    
}
