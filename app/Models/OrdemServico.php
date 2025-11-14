<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrdemServico extends Model
{
    use HasFactory;

    protected $table = 'ordens_servico';

    protected $fillable =[
        'titulo',
        'descricao',
        'status',
        'prioridade',
        'solicitante_id',
    ];

    public function solicitante(){
        return $this->belongsTo(User::class, 'solicitante_id');
    }

    protected $casts = [
    'created_at' => 'datetime:d/m/Y',
    'updated_at' => 'datetime:d/m/Y',
];
}
