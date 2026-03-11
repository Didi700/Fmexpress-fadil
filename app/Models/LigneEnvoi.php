<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneEnvoi extends Model
{
    protected $table = 'lignes_envoi';

    protected $fillable = [
        'envoi_id',
        'categorie_produit',
        'quantite',
        'poids_unitaire',
        'poids_total',
        'prix_unitaire',
        'prix_total',
        'description',
    ];

    protected $casts = [
        'quantite' => 'integer',
        'poids_unitaire' => 'decimal:2',
        'poids_total' => 'decimal:2',
        'prix_unitaire' => 'decimal:2',
        'prix_total' => 'decimal:2',
    ];

    // Relation avec Envoi
    public function envoi()
    {
        return $this->belongsTo(Envoi::class);
    }

    // Labels des catégories
    public function getCategorieLabel()
    {
        $labels = [
            'TELEPHONE' => '📱 Téléphone portable',
            'MONTRE' => '⌚ Montre connectée',
            'ECOUTEURS' => '🎧 Écouteurs/Casque',
            'APPAREIL_PHOTO' => '📷 Appareil photo',
            'ORDINATEUR_PORTABLE' => '💻 Ordinateur portable',
            'ORDINATEUR_BUREAU' => '🖥️ Ordinateur de bureau',
            'CONSOLE_JEU' => '🎮 Console de jeu',
            'STANDARD' => '📦 Produit standard',
            'DOCUMENT' => '📄 Document',
        ];

        return $labels[$this->categorie_produit] ?? $this->categorie_produit;
    }
}