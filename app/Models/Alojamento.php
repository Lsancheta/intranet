<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alojamento extends Model
{
    use HasFactory;
    protected $table= 'alojamentos';
    protected $fillable =['nome'];

    public function blocos(){
        return $this->hasMany(Bloco::class);
    }
}
