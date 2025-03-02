<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    use SoftDeletes;

    protected $fillable = ['nome', 'descricao', 'vagas', 'imagem', 'token', 'is_paid', 'price'];

    protected $dates = ['deleted_at'];

    public function dias()
    {
        return $this->hasMany(EventoDia::class);
    }

    public function presencas()
    {
        return $this->hasMany(Presenca::class);
    }
}