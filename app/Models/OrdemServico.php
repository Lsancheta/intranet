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
        'prioridade_id',
        'solicitante_id',
        'alojamento_id',
        'bloco_id',
        'quarto_id',
        'status_id',
    ];

    public function solicitante(){
        return $this->belongsTo(User::class, 'solicitante_id');
    }

    public function alojamento(){
        return $this->belongsTo(Alojamento::class, 'alojamento_id');
    }

    public function bloco(){
        return $this->belongsTo(Bloco::class, 'bloco_id');
    }

    public function quarto(){
        return $this->belongsTo(Quarto::class, 'quarto_id');
    }

    public function comentarios(){
        return $this->hasMany(ComentarioOs::class, 'ordem_servico_id')->latest();
    }

    public function fotos(){
        return $this -> hasMany(\App\Models\OsFoto::class, 'ordem_servico_id');
    }

    public function status(){
        return $this->belongsTo(StatusOs::class,'status_id');
    }

    public function getStatusFormatadoAttribute(){

        return match($this ->status->nome){
            'aberto' => 'Aberta',
            'em_andamento'=>'Em andamento',
            'pendente'=>'Pendente',
            'resolvido'=>'Concluída',
            default=> 'Desconhecido'
        };
    }

    public function prioridade(){
        return $this->belongsTo(Prioridade::class);
    }

    protected $casts = [
    'created_at' => 'datetime:d/m/Y',
    'updated_at' => 'datetime:d/m/Y',
    ];
}
