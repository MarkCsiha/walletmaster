<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Events\Registered;

class User extends Authenticatable implements MustVerifyEmail
{
    const CREATED_AT = 'regisztralt';
    const UPDATED_AT = 'utoljara_modositott';
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            //ezzel kapja meg az email hitelesítés oszlop típusát
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $table = "users";
    protected $primaryKey = "id";
}
