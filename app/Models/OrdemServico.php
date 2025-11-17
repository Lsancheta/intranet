<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrdemServico extends Model
{
    use HasFactory;

    protected $table = 'ordens_servico';

    protected $fillable = [
        'titulo',
        'descricao',
        'status',
        'prioridade',
        'solicitante_id',
        'alojamento_id',
        'bloco_id',
        'quarto_id',
    ];

    public function solicitante(){
        return $this->belongsTo(User::class, 'solicitante_id');
    }

    public function alojamento(){
        return $this->belongsTo(Alojamentos::class, 'alojamento_id');
    }

    public function bloco(){
        return $this->belongsTo(Blocos::class, 'bloco_id');
    }

    public function quarto(){
        return $this->belongsTo(Quartos::class, 'quarto_id');
    }

    public function comentarios(){
        return $this->hasMany(ComentarioOs::class, 'ordem_servico_id')->latest();
    }

    public function fotos(){
        return $this -> hasMany(\App\Models\OsFoto::class, 'ordem_servico_id');
    }

    protected $casts = [
    'created_at' => 'datetime:d/m/Y',
    'updated_at' => 'datetime:d/m/Y',
    ];
}
