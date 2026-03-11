<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Envoi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $stats = [
            'total_envois' => $user->envois()->count(),
            'en_cours' => $user->envois()->whereNotIn('statut', ['LIVRE', 'ANNULEE'])->count(),
            'livres' => $user->envois()->where('statut', 'LIVRE')->count(),
            'total_depense' => $user->envois()->sum('prix_total'),
        ];

        $envois = $user->envois()->orderBy('created_at', 'desc')->get();

        return view('client.dashboard.index', compact('user', 'stats', 'envois'));
    }

    // Afficher le formulaire de création
    public function createEnvoi()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('client.envois.create', compact('user'));
    }

    // Enregistrer un nouvel envoi
    public function storeEnvoi(Request $request)
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'expediteur_ville' => 'required|string|max:255',
            'expediteur_adresse' => 'required|string|max:500',
            'expediteur_code_postal' => 'required|string|max:10',
            'destinataire_nom' => 'required|string|max:255',
            'destinataire_telephone' => 'required|string|max:20',
            'destinataire_adresse' => 'required|string|max:500',
            'destinataire_ville' => 'required|string|max:255',
            'categorie_produit' => 'required|string',
            'poids_kg' => 'required|numeric|min:0.1|max:100',
            'longueur_cm' => 'nullable|numeric|min:1',
            'largeur_cm' => 'nullable|numeric|min:1',
            'hauteur_cm' => 'nullable|numeric|min:1',
            'description_contenu' => 'nullable|string|max:1000',
            'valeur_declaree' => 'nullable|numeric|min:0',
            'mode_livraison' => 'required|string|in:EXPRESS,URGENTE',
            'assurance' => 'boolean',
        ]);

        // Calculer le prix de base selon la catégorie
        $prixBase = $this->calculerPrixParCategorie(
            $validated['categorie_produit'],
            $validated['poids_kg']
        );

        // Appliquer le multiplicateur du mode de livraison
        $multiplicateurs = [
            'EXPRESS' => 1,      // Prix normal
            'URGENTE' => 1.5,    // +50%
        ];
        
        $prixBase = $prixBase * ($multiplicateurs[$validated['mode_livraison']] ?? 1);

        // Calculer l'assurance
        $prixAssurance = ($validated['assurance'] ?? false) ? ($validated['valeur_declaree'] ?? 0) * 0.02 : 0;
        $prixTotal = $prixBase + $prixAssurance;

        // Générer le numéro de suivi
        $numeroSuivi = Envoi::generateNumeroSuivi();

        // Créer l'envoi
        $envoi = Envoi::create([
            'user_id' => $user->id,
            'numero_suivi' => $numeroSuivi,
            'expediteur_ville' => $validated['expediteur_ville'],
            'expediteur_adresse' => $validated['expediteur_adresse'],
            'expediteur_code_postal' => $validated['expediteur_code_postal'],
            'destinataire_nom' => $validated['destinataire_nom'],
            'destinataire_telephone' => $validated['destinataire_telephone'],
            'destinataire_adresse' => $validated['destinataire_adresse'],
            'destinataire_ville' => $validated['destinataire_ville'],
            'type_colis' => $validated['categorie_produit'],
            'poids_kg' => $validated['poids_kg'],
            'longueur_cm' => $validated['longueur_cm'] ?? null,
            'largeur_cm' => $validated['largeur_cm'] ?? null,
            'hauteur_cm' => $validated['hauteur_cm'] ?? null,
            'description_contenu' => $validated['description_contenu'] ?? null,
            'valeur_declaree' => $validated['valeur_declaree'] ?? null,
            'mode_livraison' => $validated['mode_livraison'],
            'assurance' => $validated['assurance'] ?? false,
            'prix_base' => $prixBase,
            'prix_assurance' => $prixAssurance,
            'prix_total' => $prixTotal,
            'statut' => 'EN_ATTENTE_CONFIRMATION',
            'statut_paiement' => 'EN_ATTENTE',
        ]);

        return redirect()->route('envois.show', $envoi->id)->with('success', 'Votre envoi a été créé avec succès ! Numéro de suivi : ' . $numeroSuivi);
    }

    // Afficher les détails d'un envoi
    public function showEnvoi($id)
    {
        $user = Auth::user();
        
        $envoi = Envoi::where('user_id', $user->id)->findOrFail($id);

        return view('client.envois.show', compact('user', 'envoi'));
    }

    /**
     * Calculer le prix selon la catégorie de produit
     * 
     * GRILLE TARIFAIRE FMEXPRESS
     * 
     * 🔌 Produits à prix forfaitaire (Électronique) :
     * - 📱 Téléphone portable : 60€
     * - ⌚ Montre connectée : 40€
     * - 🎧 Écouteurs/Casque : 45€
     * - 📷 Appareil photo : 100€
     * 
     * 💻 Produits au poids (Électronique) :
     * - 💻 Ordinateur portable : 35€/kg
     * - 🖥️ Ordinateur de bureau : 40€/kg
     * - 🎮 Console de jeu : 40€/kg
     * 
     * 📦 Produits standard :
     * - 📦 Produit standard : 15€/kg
     * - 📄 Document : 10€/kg
     * 
     * ⚡ Modes de livraison :
     * - ✈️ EXPRESS (7-10j) : Prix normal (x1)
     * - 🚀 URGENTE (3-5j) : +50% (x1.5)
     * 
     * @param string $categorie
     * @param float $poids
     * @return float
     */
    private function calculerPrixParCategorie($categorie, $poids)
    {
        // 🔌 Produits à prix forfaitaire (indépendant du poids)
        $prixForfaitaires = [
            'TELEPHONE' => 60,          // 📱 Téléphone portable
            'MONTRE' => 40,             // ⌚ Montre connectée
            'ECOUTEURS' => 45,          // 🎧 Écouteurs/Casque
            'APPAREIL_PHOTO' => 100,    // 📷 Appareil photo
        ];

        // Si c'est un produit à prix forfaitaire, retourner le prix fixe
        if (isset($prixForfaitaires[$categorie])) {
            return $prixForfaitaires[$categorie];
        }

        // 💻 Produits au poids (prix par kg)
        $prixParKg = [
            'ORDINATEUR_PORTABLE' => 35,    // 💻 Ordinateur portable - 35€/kg
            'ORDINATEUR_BUREAU' => 40,      // 🖥️ Ordinateur de bureau - 40€/kg
            'CONSOLE_JEU' => 40,            // 🎮 Console de jeu - 40€/kg
            'STANDARD' => 15,               // 📦 Produit standard - 15€/kg
            'DOCUMENT' => 10,               // 📄 Document - 10€/kg
        ];

        $tarifParKg = $prixParKg[$categorie] ?? 15; // Par défaut 15€/kg

        return $poids * $tarifParKg;
    }
}