<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class ComentarioOs extends Model
{
    use HasFactory;

    protected $table = 'comentarios_os';

    protected $fillable = [
        'ordem_servico_id',
        'user_id',
        'comentario'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ordem(){
        return $this->belongsTo(OrdemServico::class, 'ordem_servico_id');
    }

    // mudar o horario para timezone sp
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->timezone('America/Sao_Paulo')->format('d/m/Y H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->timezone('America/Sao_Paulo')->format('d/m/Y H:i');
    }


    protected $casts = [
    'created_at' => 'datetime:d/m/Y H:i',
    'updated_at' => 'datetime:d/m/Y H;i',
    ];
}
