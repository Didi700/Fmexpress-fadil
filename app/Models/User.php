<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'prenom',
        'nom',
        'email',
        'password',
        'telephone',
        'adresse',
        'ville',
        'code_postal',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relations
    public function envois()
    {
        return $this->hasMany(Envoi::class);
    }

    public function logsActions()
    {
        return $this->hasMany(LogActionAdmin::class, 'admin_id');
    }

    // Helpers
    public function isAdmin()
    {
        return in_array($this->role, ['ADMIN', 'SUPER_ADMIN']);
    }

    public function isSuperAdmin()
    {
        return $this->role === 'SUPER_ADMIN';
    }

    public function isClient()
    {
        return $this->role === 'CLIENT';
    }

    public function getFullNameAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }
}