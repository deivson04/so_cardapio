<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Users extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $primaryKey = 'id';

    protected $fillable = [
        'nome',
        'email',
        'numero_celular',
        'senha',
        'is_admin',
    ];

    protected $casts = [
        //'email_verified_at' => 'datetime',
        'senha' => 'hashed', // <-- MUITO IMPORTANTE: Garante que a senha é hash ao ser setada
    ];

    protected $table = 'users'; 
}
