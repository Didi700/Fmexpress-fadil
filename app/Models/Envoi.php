<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Envoi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'numero_suivi',
        'expediteur_ville',
        'expediteur_adresse',
        'expediteur_code_postal',
        'destinataire_nom',
        'destinataire_telephone',
        'destinataire_adresse',
        'destinataire_ville',
        'type_colis',
        'poids_kg',
        'longueur_cm',
        'largeur_cm',
        'hauteur_cm',
        'description_contenu',
        'valeur_declaree',
        'photo_colis_1',
        'photo_colis_2',
        'photo_colis_3',
        'mode_livraison',
        'assurance',
        'prix_base',
        'prix_assurance',
        'prix_total',
        'statut',
        'statut_paiement',
    ];

    protected $casts = [
        'assurance' => 'boolean',
        'poids_kg' => 'decimal:2',
        'prix_base' => 'decimal:2',
        'prix_assurance' => 'decimal:2',
        'prix_total' => 'decimal:2',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(LogActionAdmin::class);
    }

    // Helpers
    public static function generateNumeroSuivi()
    {
        $year = date('Y');
        $month = date('m');
        
        $lastEnvoi = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastEnvoi ? (int)substr($lastEnvoi->numero_suivi, -4) + 1 : 1;
        
        return 'FM' . $year . $month . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public function getStatusColorAttribute()
    {
        return match($this->statut) {
            'EN_ATTENTE_CONFIRMATION' => 'warning',
            'CONFIRMEE' => 'primary',
            'RECUPERE' => 'info',
            'EN_PREPARATION' => 'secondary',
            'EN_TRANSIT' => 'primary',
            'ARRIVE_BENIN' => 'info',
            'EN_LIVRAISON' => 'success',
            'LIVRE' => 'success',
            'ANNULEE' => 'danger',
            default => 'secondary',
        };
    }

    public function getStatusLabelAttribute()
    {
        return match($this->statut) {
            'EN_ATTENTE_CONFIRMATION' => 'En attente',
            'CONFIRMEE' => 'Confirmée',
            'RECUPERE' => 'Récupéré',
            'EN_PREPARATION' => 'En préparation',
            'EN_TRANSIT' => 'En transit',
            'ARRIVE_BENIN' => 'Arrivé au Bénin',
            'EN_LIVRAISON' => 'En livraison',
            'LIVRE' => 'Livré',
            'ANNULEE' => 'Annulée',
            default => $this->statut,
        };
    }

    // Relation avec les lignes d'envoi

    public function lignes()
    {
        return $this->hasMany(LigneEnvoi::class);
    }

    
}