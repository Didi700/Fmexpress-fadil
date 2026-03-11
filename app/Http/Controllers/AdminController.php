<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Envoi;
use App\Models\EnvoiLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Dashboard Admin
    public function dashboard()
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            return redirect()->route('dashboard');
        }

        $stats = [
            'total_envois' => Envoi::count(),
            'total_clients' => User::where('role', 'CLIENT')->count(),
            'en_attente' => Envoi::where('statut', 'EN_ATTENTE_CONFIRMATION')->count(),
            'en_transit' => Envoi::whereIn('statut', ['EN_TRANSIT', 'EN_PREPARATION', 'RECUPERE'])->count(),
            'livres' => Envoi::where('statut', 'LIVRE')->count(),
            'revenu_total' => Envoi::sum('prix_total'),
            'revenu_mois' => Envoi::whereMonth('created_at', now()->month)
                                  ->whereYear('created_at', now()->year)
                                  ->sum('prix_total'),
        ];

        $envois = Envoi::with('user')->orderBy('created_at', 'desc')->take(10)->get();

        return view('admin.dashboard.index', compact('user', 'stats', 'envois'));
    }

    // Liste des envois
    public function envois()
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            return redirect()->route('dashboard');
        }

        $envois = Envoi::with('user')->orderBy('created_at', 'desc')->get();

        return view('admin.envois.index', compact('envois'));
    }

    // Détails d'un envoi
    public function showEnvoi($id)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            return redirect()->route('dashboard');
        }

        $envoi = Envoi::with(['user', 'lignes', 'logs.admin'])->findOrFail($id);

        return view('admin.envois.show', compact('envoi'));
    }

    // Changer le statut d'un envoi
    public function updateStatus(Request $request, $id)
    {
        $admin = Auth::user();
        
        if (!$admin->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'statut' => 'required|string|in:EN_ATTENTE_CONFIRMATION,CONFIRMEE,RECUPERE,EN_PREPARATION,EN_TRANSIT,ARRIVE_BENIN,EN_LIVRAISON,LIVRE,ANNULEE',
        ]);

        $envoi = Envoi::findOrFail($id);
        $ancienStatut = $envoi->statut;
        
        $envoi->statut = $validated['statut'];
        $envoi->save();

        // Logger l'action
        EnvoiLog::create([
            'envoi_id' => $envoi->id,
            'admin_id' => $admin->id,
            'action' => 'Changement de statut',
            'ancienne_valeur' => $ancienStatut,
            'nouvelle_valeur' => $validated['statut'],
        ]);

        return back()->with('success', 'Statut mis à jour avec succès !');
    }

    // Mettre à jour le statut de paiement
    public function updatePaiement(Request $request, $id)
    {
        $admin = Auth::user();
        
        if (!$admin->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'statut_paiement' => 'required|string|in:EN_ATTENTE,PAYE,REMBOURSE',
        ]);

        $envoi = Envoi::findOrFail($id);
        
        $ancienStatut = $envoi->statut_paiement;
        $envoi->statut_paiement = $validated['statut_paiement'];
        $envoi->save();

        // Logger l'action
        EnvoiLog::create([
            'envoi_id' => $envoi->id,
            'admin_id' => $admin->id,
            'action' => 'Changement statut paiement',
            'ancienne_valeur' => $ancienStatut,
            'nouvelle_valeur' => $validated['statut_paiement'],
        ]);

        return back()->with('success', 'Statut de paiement mis à jour avec succès !');
    }

    // Liste des clients
    public function clients()
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            return redirect()->route('dashboard');
        }

        $clients = User::where('role', 'CLIENT')
            ->withCount('envois')
            ->withSum('envois', 'prix_total')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.clients.index', compact('clients'));
    }

    // Détails d'un client
    public function showClient($id)
    {
        $user = Auth::user();
        
        if (!$user->isAdmin()) {
            return redirect()->route('dashboard');
        }

        $client = User::where('role', 'CLIENT')->findOrFail($id);
        
        $stats = [
            'total_envois' => $client->envois()->count(),
            'ca_total' => $client->envois()->sum('prix_total'),
            'dernier_envoi' => $client->envois()->orderBy('created_at', 'desc')->first()?->created_at,
        ];

        $envois = $client->envois()->with('lignes')->orderBy('created_at', 'desc')->get();

        return view('admin.clients.show', compact('client', 'stats', 'envois'));
    }

    // Liste des administrateurs
    public function admins()
    {
        $user = Auth::user();
        
        if (!$user->isSuperAdmin()) {
            abort(403, 'Accès refusé - Réservé aux Super Admins');
        }

        $admins = User::whereIn('role', ['ADMIN', 'SUPER_ADMIN'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.admins.index', compact('admins'));
    }

    // Créer un administrateur
    public function createAdmin(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isSuperAdmin()) {
            abort(403, 'Accès refusé - Réservé aux Super Admins');
        }

        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:ADMIN,SUPER_ADMIN',
        ]);

        $newAdmin = User::create([
            'prenom' => $validated['prenom'],
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('admin.admins')->with('success', 'Administrateur créé avec succès !');
    }

    // Supprimer un administrateur
    public function deleteAdmin($id)
    {
        $user = Auth::user();
        
        if (!$user->isSuperAdmin()) {
            abort(403, 'Accès refusé - Réservé aux Super Admins');
        }

        // Empêcher la suppression de soi-même
        if ($id == $user->id) {
            return back()->withErrors(['error' => 'Vous ne pouvez pas supprimer votre propre compte.']);
        }

        $admin = User::whereIn('role', ['ADMIN', 'SUPER_ADMIN'])->findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.admins')->with('success', 'Administrateur supprimé avec succès !');
    }

    // Statistiques avancées
public function statistiques(Request $request)
{
    $user = Auth::user();
    
    if (!$user->isAdmin()) {
        return redirect()->route('dashboard');
    }

    // Période par défaut : 12 derniers mois
    $moisDebut = $request->input('mois_debut', now()->subMonths(11)->format('Y-m'));
    $moisFin = $request->input('mois_fin', now()->format('Y-m'));

    // Statistiques globales
    $statsGlobales = [
        'total_envois' => Envoi::count(),
        'total_clients' => User::where('role', 'CLIENT')->count(),
        'revenu_total' => Envoi::sum('prix_total'),
        'poids_total' => Envoi::sum('poids_kg'),
        'panier_moyen' => Envoi::count() > 0 ? Envoi::sum('prix_total') / Envoi::count() : 0,
    ];

    // Revenus par mois - SYNTAXE POSTGRESQL
    $revenusParMois = Envoi::selectRaw('EXTRACT(YEAR FROM created_at)::integer as annee, EXTRACT(MONTH FROM created_at)::integer as mois, SUM(prix_total) as revenu, COUNT(*) as nombre_envois')
        ->whereBetween('created_at', [
            \Carbon\Carbon::parse($moisDebut)->startOfMonth(),
            \Carbon\Carbon::parse($moisFin)->endOfMonth()
        ])
        ->groupByRaw('EXTRACT(YEAR FROM created_at), EXTRACT(MONTH FROM created_at)')
        ->orderByRaw('EXTRACT(YEAR FROM created_at), EXTRACT(MONTH FROM created_at)')
        ->get();

    // Préparer les données pour le graphique
    $labels = [];
    $dataRevenus = [];
    $dataEnvois = [];
    
    foreach ($revenusParMois as $revenu) {
        $labels[] = sprintf('%02d/%d', $revenu->mois, $revenu->annee);
        $dataRevenus[] = round($revenu->revenu, 2);
        $dataEnvois[] = $revenu->nombre_envois;
    }

    // Statistiques par statut
    $statsParStatut = Envoi::selectRaw('statut, COUNT(*) as nombre, SUM(prix_total) as revenu')
        ->groupBy('statut')
        ->get();

    // Statistiques par mode de livraison
    $statsParMode = Envoi::selectRaw('mode_livraison, COUNT(*) as nombre, SUM(prix_total) as revenu')
        ->groupBy('mode_livraison')
        ->get();

    // Top 5 clients
    $topClients = User::where('role', 'CLIENT')
        ->withCount('envois')
        ->withSum('envois', 'prix_total')
        ->orderBy('envois_sum_prix_total', 'desc')
        ->take(5)
        ->get();

    // Statistiques par catégorie de produit
    $statsParCategorie = \DB::table('lignes_envoi')
        ->selectRaw('categorie_produit, COUNT(*) as nombre, SUM(prix_total) as revenu')
        ->groupBy('categorie_produit')
        ->orderBy('revenu', 'desc')
        ->get();

    return view('admin.statistiques.index', compact(
        'statsGlobales',
        'labels',
        'dataRevenus',
        'dataEnvois',
        'statsParStatut',
        'statsParMode',
        'topClients',
        'statsParCategorie',
        'moisDebut',
        'moisFin'
    ));
}
}