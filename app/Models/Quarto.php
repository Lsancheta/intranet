<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quarto extends Model
{
    use HasFactory;

    protected $fillable = ['numero', 'bloco_id'];

    public function bloco(){
        return $this->belongsTo(Bloco::class);
    }
}
