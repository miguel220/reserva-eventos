<?php

namespace App\Models;

use App\Notifications\CustomResetPassword;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'is_admin', 'phone_number', 'email_verified_at', 'is_seeder', 'setor_id', 'is_producer'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
        'is_seeder' => 'boolean',
        'is_producer' => 'boolean',
    ];

    protected $dates = ['deleted_at'];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail());
    }

    public function setor()
    {
        return $this->belongsTo(Setor::class);
    }
    
    public function escalas()
    {
        return $this->belongsToMany(Escala::class, 'escala_user')
                    ->withPivot('confirmado', 'motivo_ausencia')
                    ->withTimestamps();
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }
}