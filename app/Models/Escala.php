<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escala extends Model
{
    use HasFactory;

    protected $fillable = [
        'evento_id', 
        'data', 
        'setor_id',
    ];

    protected $casts = [
        'data' => 'date',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function setor()
    {
        return $this->belongsTo(Setor::class);
    }

    public function voluntarios()
    {
        return $this->belongsToMany(User::class, 'escala_user')
                    ->withPivot('confirmado', 'motivo_ausencia')
                    ->withTimestamps();
    }
}