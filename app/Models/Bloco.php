<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bloco extends Model
{
    use HasFactory;

    protected $fillable = ['nome','alojamento_id'];

    public function alojamento(){
        return $this->belongsTo(Alojamento::class);
    }

    public function quartos(){
        return $this->hasMany(Quarto::class);
    }
}
