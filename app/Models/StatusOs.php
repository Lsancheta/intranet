<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusOs extends Model
{
    use HasFactory;

    protected $table = 'status_os';

    protected $fillable = [
        'nome',
        'cor',
        'ordem'
    ];

    public function ordens()
    {
        return $this->hasMany(OrdemServico::class, 'status_id');
    }
}
