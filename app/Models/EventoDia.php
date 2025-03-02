<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventoDia extends Model
{
    protected $fillable = ['evento_id', 'data', 'hora_inicio', 'hora_fim'];

    // Definir campos que devem ser tratados como instâncias Carbon
    protected $dates = ['data'];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }
}