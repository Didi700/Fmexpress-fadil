<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActionAdmin extends Model
{
    use HasFactory;

    protected $table = 'logs_actions_admin';

    protected $fillable = [
        'admin_id',
        'envoi_id',
        'action_effectuee',
    ];

    // Relations
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function envoi()
    {
        return $this->belongsTo(Envoi::class);
    }
}