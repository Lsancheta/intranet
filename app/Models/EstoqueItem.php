<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EstoqueItem extends Model
{
    use HasFactory;

    protected $table = 'estoque_items';

    protected $fillable = [
        'produto_id',
        'local_id',
        'quantidade',
        'estoque_minimo',
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
