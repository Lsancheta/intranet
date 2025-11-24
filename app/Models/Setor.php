<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    protected $table = 'setores';

    protected $fillable = ['cargo'];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
