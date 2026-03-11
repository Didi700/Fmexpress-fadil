<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Envoi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin - Fadil
        $fadil = User::create([
            'prenom' => 'Fadil',
            'nom' => 'ASSANE',
            'email' => 'fadilassane700@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'SUPER_ADMIN',
        ]);

        // Super Admin - Mazid
        $mazid = User::create([
            'prenom' => 'Mazid',
            'nom' => 'ASSANE',
            'email' => 'mazid@fmexpress.com',
            'password' => Hash::make('password'),
            'role' => 'SUPER_ADMIN',
        ]);

        // Admin test
        $admin = User::create([
            'prenom' => 'John',
            'nom' => 'DOE',
            'email' => 'admin@fmexpress.com',
            'password' => Hash::make('password'),
            'role' => 'ADMIN',
        ]);

        // Client test
        $client = User::create([
            'prenom' => 'Marie',
            'nom' => 'Dossa',
            'email' => 'marie@example.com',
            'password' => Hash::make('password'),
            'telephone' => '+229 97 65 45 67',
            'adresse' => '123 Rue de Test',
            'ville' => 'Porto-Novo',
            'code_postal' => '00229',
            'role' => 'CLIENT',
        ]);

        // Envoi de test
        Envoi::create([
            'user_id' => $client->id,
            'numero_suivi' => 'FM25124766',
            'expediteur_ville' => 'Paris',
            'expediteur_adresse' => '10 Avenue des Champs-Élysées',
            'expediteur_code_postal' => '75008',
            'destinataire_nom' => 'Marie Dossa',
            'destinataire_telephone' => '+229 97 65 45 67',
            'destinataire_adresse' => 'Quartier Zongo',
            'destinataire_ville' => 'Porto-Novo',
            'type_colis' => 'COLIS',
            'poids_kg' => 7.00,
            'description_contenu' => 'Vêtements et accessoires',
            'mode_livraison' => 'DOMICILE',
            'assurance' => false,
            'prix_base' => 119.50,
            'prix_assurance' => 0,
            'prix_total' => 119.50,
            'statut' => 'EN_ATTENTE_CONFIRMATION',
            'statut_paiement' => 'EN_ATTENTE',
        ]);

        // 2 autres envois de test
        Envoi::create([
            'user_id' => $client->id,
            'numero_suivi' => Envoi::generateNumeroSuivi(),
            'expediteur_ville' => 'Lyon',
            'expediteur_adresse' => '5 Place Bellecour',
            'expediteur_code_postal' => '69002',
            'destinataire_nom' => 'Jean Kouton',
            'destinataire_telephone' => '+229 96 12 34 56',
            'destinataire_adresse' => 'Rue Nouvelle',
            'destinataire_ville' => 'Cotonou',
            'type_colis' => 'DOCUMENT',
            'poids_kg' => 2.50,
            'description_contenu' => 'Documents administratifs',
            'mode_livraison' => 'POINT_RELAIS',
            'assurance' => true,
            'prix_base' => 45.00,
            'prix_assurance' => 5.00,
            'prix_total' => 50.00,
            'statut' => 'EN_TRANSIT',
            'statut_paiement' => 'PAYE',
        ]);

        Envoi::create([
            'user_id' => $client->id,
            'numero_suivi' => Envoi::generateNumeroSuivi(),
            'expediteur_ville' => 'Marseille',
            'expediteur_adresse' => '1 Vieux Port',
            'expediteur_code_postal' => '13001',
            'destinataire_nom' => 'Sophie Akpovi',
            'destinataire_telephone' => '+229 97 88 99 00',
            'destinataire_adresse' => 'Avenue de la République',
            'destinataire_ville' => 'Parakou',
            'type_colis' => 'COLIS',
            'poids_kg' => 15.00,
            'description_contenu' => 'Équipements électroniques',
            'mode_livraison' => 'DOMICILE',
            'assurance' => true,
            'prix_base' => 180.00,
            'prix_assurance' => 20.00,
            'prix_total' => 200.00,
            'statut' => 'LIVRE',
            'statut_paiement' => 'PAYE',
        ]);
    }
}