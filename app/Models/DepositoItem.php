<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DepositoItem extends Model
{
    use HasFactory;

    protected $table = 'deposito_items';

    protected $fillable = [
        'produto_id',
        'local_id',
        'quantidade',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relacionamentos
    |--------------------------------------------------------------------------
    */

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function local()
    {
        return $this->belongsTo(Local::class);
    }
}
