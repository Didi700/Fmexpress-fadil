@extends('layouts.app')

@section('title', 'Mes Envois - FMEXPRESS')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-green-50">
    <!-- HEADER -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>

                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="FMEXPRESS" class="w-12 h-12 rounded-lg">
                        <div>
                            <div class="font-black text-xl text-gray-900">FMEXPRESS</div>
                            <div class="text-xs text-gray-600 font-semibold">🇫🇷 Le Pont des Nations 🇧🇯</div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('profil') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-bold hover:bg-indigo-700 transition">
                        👤 Mon Profil
                    </a>
                    <div class="text-right">
                        <div class="font-bold text-gray-900">{{ $user->full_name }}</div>
                        <div class="text-xs text-gray-600">{{ $user->email }}</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-bold transition">
                            🚪 Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- TITRE -->
        <div class="mb-8">
            <h1 class="text-3xl font-black text-gray-900 mb-2">📦 Tous mes envois</h1>
            <p class="text-gray-600">Gérez et suivez l'historique complet de vos envois</p>
        </div>

        <!-- STATISTIQUES -->
        <div class="grid grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-3xl">📦</div>
                    <div class="text-3xl font-black text-gray-900">{{ $stats['total'] }}</div>
                </div>
                <div class="text-sm text-gray-600 font-semibold">Total</div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-3xl">⏳</div>
                    <div class="text-3xl font-black text-blue-600">{{ $stats['en_cours'] }}</div>
                </div>
                <div class="text-sm text-gray-600 font-semibold">En cours</div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-3xl">✅</div>
                    <div class="text-3xl font-black text-green-600">{{ $stats['livres'] }}</div>
                </div>
                <div class="text-sm text-gray-600 font-semibold">Livrés</div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-3xl">❌</div>
                    <div class="text-3xl font-black text-red-600">{{ $stats['annules'] }}</div>
                </div>
                <div class="text-sm text-gray-600 font-semibold">Annulés</div>
            </div>
        </div>

        <!-- FILTRES ET RECHERCHE -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8">
            <form method="GET" action="{{ route('envois.liste') }}" class="space-y-4">
                <!-- RECHERCHE -->
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">🔍 Recherche</label>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $search }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        placeholder="Numéro de suivi, ville, nom du destinataire..."
                    >
                </div>

                <!-- FILTRES -->
                <div class="grid grid-cols-4 gap-4">
                    <!-- STATUT -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Statut</label>
                        <select name="statut" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="">Tous</option>
                            <option value="EN_ATTENTE_CONFIRMATION" {{ $statut == 'EN_ATTENTE_CONFIRMATION' ? 'selected' : '' }}>En attente</option>
                            <option value="CONFIRMEE" {{ $statut == 'CONFIRMEE' ? 'selected' : '' }}>Confirmée</option>
                            <option value="RECUPERE" {{ $statut == 'RECUPERE' ? 'selected' : '' }}>Récupéré</option>
                            <option value="EN_PREPARATION" {{ $statut == 'EN_PREPARATION' ? 'selected' : '' }}>En préparation</option>
                            <option value="EN_TRANSIT" {{ $statut == 'EN_TRANSIT' ? 'selected' : '' }}>En transit</option>
                            <option value="ARRIVE_BENIN" {{ $statut == 'ARRIVE_BENIN' ? 'selected' : '' }}>Arrivé au Bénin</option>
                            <option value="EN_LIVRAISON" {{ $statut == 'EN_LIVRAISON' ? 'selected' : '' }}>En livraison</option>
                            <option value="LIVRE" {{ $statut == 'LIVRE' ? 'selected' : '' }}>Livré</option>
                            <option value="ANNULEE" {{ $statut == 'ANNULEE' ? 'selected' : '' }}>Annulé</option>
                        </select>
                    </div>

                    <!-- MODE DE LIVRAISON -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Mode</label>
                        <select name="mode_livraison" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                            <option value="">Tous</option>
                            <option value="EXPRESS" {{ $mode_livraison == 'EXPRESS' ? 'selected' : '' }}>Express</option>
                            <option value="URGENTE" {{ $mode_livraison == 'URGENTE' ? 'selected' : '' }}>Urgente</option>
                        </select>
                    </div>

                    <!-- DATE DÉBUT -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Du</label>
                        <input 
                            type="date" 
                            name="date_debut" 
                            value="{{ $date_debut }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        >
                    </div>

                    <!-- DATE FIN -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Au</label>
                        <input 
                            type="date" 
                            name="date_fin" 
                            value="{{ $date_fin }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        >
                    </div>
                </div>

                <!-- BOUTONS -->
                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-lg font-bold hover:shadow-lg transition">
                        🔍 Rechercher
                    </button>
                    <a href="{{ route('envois.liste') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-bold hover:bg-gray-300 transition">
                        🔄 Réinitialiser
                    </a>
                </div>
            </form>
        </div>

        <!-- TABLEAU DES ENVOIS -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-black text-gray-900">Liste des envois</h2>
                    <p class="text-sm text-gray-600 mt-0.5">{{ $envois->total() }} envoi(s) trouvé(s)</p>
                </div>
                <a href="{{ route('envois.create') }}" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-lg font-bold hover:shadow-lg transition">
                    ➕ Nouvel Envoi
                </a>
            </div>

            @if($envois->isEmpty())
                <div class="py-20 text-center">
                    <div class="text-8xl mb-4">🔍</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Aucun envoi trouvé</h3>
                    <p class="text-gray-600 mb-6">Essayez de modifier vos critères de recherche</p>
                    <a href="{{ route('envois.liste') }}" class="inline-block px-8 py-4 bg-gray-200 text-gray-700 rounded-lg font-bold hover:bg-gray-300 transition">
                        🔄 Réinitialiser les filtres
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">N° Suivi</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Route</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Articles</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Poids</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Mode</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Prix</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Statut</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Date</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($envois as $envoi)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-4">
                                    <span class="font-mono text-sm font-black text-blue-600">{{ $envoi->numero_suivi }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-sm text-gray-900">{{ $envoi->expediteur_ville }} → {{ $envoi->destinataire_ville }}</div>
                                    <div class="text-xs text-gray-500">{{ $envoi->destinataire_nom }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold">
                                        {{ $envoi->lignes->count() }} article(s)
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-bold text-gray-900">{{ $envoi->poids_kg }} kg</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 {{ $envoi->mode_livraison == 'EXPRESS' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700' }} rounded-full text-xs font-bold">
                                        {{ $envoi->mode_livraison }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-black text-green-600">{{ number_format($envoi->prix_total, 2) }}€</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusColors = [
                                            'EN_ATTENTE_CONFIRMATION' => 'bg-yellow-500',
                                            'CONFIRMEE' => 'bg-blue-500',
                                            'RECUPERE' => 'bg-purple-500',
                                            'EN_PREPARATION' => 'bg-orange-500',
                                            'EN_TRANSIT' => 'bg-indigo-500',
                                            'ARRIVE_BENIN' => 'bg-cyan-500',
                                            'EN_LIVRAISON' => 'bg-teal-500',
                                            'LIVRE' => 'bg-green-500',
                                            'ANNULEE' => 'bg-red-500',
                                        ];
                                        $color = $statusColors[$envoi->statut] ?? 'bg-gray-500';
                                    @endphp
                                    <span class="px-3 py-1 {{ $color }} text-white rounded-full text-xs font-bold">
                                        {{ $envoi->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-700">
                                    {{ $envoi->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('envois.show', $envoi->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 transition">
                                        👁️ Voir
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $envois->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection