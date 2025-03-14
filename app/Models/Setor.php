<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    use HasFactory;

    protected $table = 'setores';

    protected $fillable = ['nome'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function escalas()
    {
        return $this->hasMany(Escala::class);
    }
}