<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnvoiLog extends Model
{
    protected $table = 'envoi_logs';

    protected $fillable = [
        'envoi_id',
        'admin_id',
        'action',
        'ancienne_valeur',
        'nouvelle_valeur',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relation avec Envoi
    public function envoi()
    {
        return $this->belongsTo(Envoi::class);
    }

    // Relation avec Admin
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}