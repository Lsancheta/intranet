<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quantitativo extends Model
{
        protected $table = 'quantitativo';
        
        protected $fillable = [
        'fazenda',
        'nome',
        'quantidade',
        'alojamento_id',
        'bloco_id',
    ]; 

     public function alojamento(){
        return $this->belongsTo(Alojamento::class, 'alojamento_id');
    }

     public function bloco(){
        return $this->belongsTo(Bloco::class, 'bloco_id');
    }
}           
