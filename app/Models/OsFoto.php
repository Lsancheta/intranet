<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;


use Illuminate\Database\Eloquent\Model;

class OsFoto extends Model
{
    use HasFactory;

    protected $table= 'os_fotos';

    protected $fillable=[
        'ordem_servico_id',
        'caminho'
    ];

    public function ordem(){

        return $this -> belongsTo(OrdemServico::class, 'ordem_servico_id');
    }
}
