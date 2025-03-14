<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Evento extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome', 'descricao', 'vagas', 'imagem', 'token', 'is_paid', 'price', 
        'promo_price', 'promo_start_date', 'promo_end_date', 'responsible'
    ];

    protected $dates = ['deleted_at', 'promo_start_date', 'promo_end_date'];

    public function dias()
    {
        return $this->hasMany(EventoDia::class);
    }

    public function presencas()
    {
        return $this->hasMany(Presenca::class);
    }

    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'responsible');
    }

    // Método para obter o preço atual (promocional ou normal)
    public function getCurrentPriceAttribute()
    {
        if (!$this->is_paid) {
            return 0; // Gratuito
        }

        $now = Carbon::now();
        if ($this->promo_price && $this->promo_start_date && $this->promo_end_date &&
            $now->between($this->promo_start_date, $this->promo_end_date)) {
            return $this->promo_price; // Preço promocional dentro do período
        }

        return $this->price; // Preço normal
    }
}