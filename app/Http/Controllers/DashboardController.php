<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Envoi;
use App\Models\LigneEnvoi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    // Dashboard principal
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

        $envois = $user->envois()->with('lignes')->orderBy('created_at', 'desc')->take(10)->get();

        return view('client.dashboard.index', compact('user', 'stats', 'envois'));
    }

    // Afficher le formulaire de création d'envoi
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
            'articles_json' => 'required|json',
            'poids_total_colis' => 'required|numeric|min:0.1',
            'description_contenu' => 'nullable|string|max:1000',
            'valeur_declaree' => 'nullable|numeric|min:0',
            'mode_livraison' => 'required|string|in:EXPRESS,URGENTE',
            'assurance' => 'boolean',
        ]);

        // Décoder les articles
        $articles = json_decode($validated['articles_json'], true);

        if (empty($articles)) {
            return back()->withErrors(['articles_json' => 'Veuillez ajouter au moins un article'])->withInput();
        }

        // Utiliser une transaction pour garantir la cohérence
        DB::beginTransaction();

        try {
            // Calculer le prix de base (somme de tous les articles)
            $prixBase = 0;
            foreach ($articles as $article) {
                $prixBase += $article['prix_total'];
            }

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

            // Créer l'envoi principal
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
                'type_colis' => 'MULTIPLE',
                'poids_kg' => $validated['poids_total_colis'],
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

            // Créer les lignes d'envoi (détails des articles)
            foreach ($articles as $article) {
                LigneEnvoi::create([
                    'envoi_id' => $envoi->id,
                    'categorie_produit' => $article['categorie'],
                    'quantite' => $article['quantite'],
                    'poids_unitaire' => $article['poids'] / $article['quantite'],
                    'poids_total' => $article['poids'],
                    'prix_unitaire' => $article['prix_unitaire'],
                    'prix_total' => $article['prix_total'],
                    'description' => $article['label'],
                ]);
            }

            DB::commit();

            return redirect()->route('envois.show', $envoi->id)->with('success', 'Votre envoi a été créé avec succès ! Numéro de suivi : ' . $numeroSuivi);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la création de l\'envoi.'])->withInput();
        }
    }

    // Afficher les détails d'un envoi
    public function showEnvoi($id)
    {
        $user = Auth::user();
        
        $envoi = Envoi::with('lignes')->where('user_id', $user->id)->findOrFail($id);

        return view('client.envois.show', compact('user', 'envoi'));
    }

    // Liste complète des envois avec recherche et filtres
    public function mesEnvois(Request $request)
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Récupérer les paramètres de recherche/filtres
        $search = $request->input('search');
        $statut = $request->input('statut');
        $mode_livraison = $request->input('mode_livraison');
        $date_debut = $request->input('date_debut');
        $date_fin = $request->input('date_fin');

        // Query de base
        $query = $user->envois()->with('lignes');

        // Recherche par numéro de suivi, ville expéditeur ou destinataire
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('numero_suivi', 'like', '%' . $search . '%')
                  ->orWhere('expediteur_ville', 'like', '%' . $search . '%')
                  ->orWhere('destinataire_ville', 'like', '%' . $search . '%')
                  ->orWhere('destinataire_nom', 'like', '%' . $search . '%');
            });
        }

        // Filtrer par statut
        if ($statut) {
            $query->where('statut', $statut);
        }

        // Filtrer par mode de livraison
        if ($mode_livraison) {
            $query->where('mode_livraison', $mode_livraison);
        }

        // Filtrer par période
        if ($date_debut) {
            $query->whereDate('created_at', '>=', $date_debut);
        }
        if ($date_fin) {
            $query->whereDate('created_at', '<=', $date_fin);
        }

        // Pagination
        $envois = $query->orderBy('created_at', 'desc')->paginate(10);

        // Statistiques pour la page
        $stats = [
            'total' => $user->envois()->count(),
            'en_cours' => $user->envois()->whereNotIn('statut', ['LIVRE', 'ANNULEE'])->count(),
            'livres' => $user->envois()->where('statut', 'LIVRE')->count(),
            'annules' => $user->envois()->where('statut', 'ANNULEE')->count(),
        ];

        return view('client.envois.liste', compact('user', 'envois', 'stats', 'search', 'statut', 'mode_livraison', 'date_debut', 'date_fin'));
    }

    // Afficher le profil
    public function profil()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('client.profil.index', compact('user'));
    }

    // Mettre à jour les informations du profil
    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telephone' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return back()->with('success', 'Vos informations ont été mises à jour avec succès !');
    }

    // Changer le mot de passe
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        // Vérifier l'ancien mot de passe
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Votre mot de passe a été changé avec succès !');
    }
}