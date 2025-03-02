<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presenca extends Model
{
    protected $fillable = ['evento_id', 'nome', 'email', 'confirmado'];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
}