<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use App\Models\Setor;

class User extends Authenticatable
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        
    ];

    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    // 🔹 Relacionamento com Ordem de Serviço
    public function ordensServico()
    {
        return $this->hasMany(OrdemServico::class, 'solicitante_id');
    }

    // 🔹 Verificação simples de administrador
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function setores(){
        return $this->belongsToMany(Setor::class, 'setor_user','user_id','setor_id');
    }
    public function inSetor($setores){
        if(!is_array($setores)){
            $setores = [$setores];
        }
        return $this->Setores()->whereIn('setor_id',$setores)->exists();
    }
}
