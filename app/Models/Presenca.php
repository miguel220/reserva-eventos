<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presenca extends Model
{
    protected $fillable = ['nome', 'email', 'contact_number', 'payment_method', 'payment_status', 'attendance_status', 'attendance_days', 'confirmado', 'evento_id', 'equipe_id'];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }
}