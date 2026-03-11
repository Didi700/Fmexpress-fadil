@extends('layouts.app')

@section('title', 'Dashboard - FMEXPRESS')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-green-50">
    <!-- HEADER -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="FMEXPRESS" class="w-12 h-12 rounded-lg">
                    <div>
                        <div class="font-black text-xl text-gray-900">FMEXPRESS</div>
                        <div class="text-xs text-gray-600 font-semibold">🇫🇷 Le Pont des Nations 🇧🇯</div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <!-- BOUTON PROFIL -->
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
        <!-- WELCOME MESSAGE -->
        <div class="mb-8">
            <h1 class="text-3xl font-black text-gray-900 mb-2">👋 Bienvenue {{ $user->prenom }} !</h1>
            <p class="text-gray-600">Gérez vos envois entre la France et le Bénin en toute simplicité</p>
        </div>

        <!-- STATS CARDS -->
        <div class="grid grid-cols-4 gap-4 mb-8">
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-4xl">📦</div>
                </div>
                <div class="text-sm font-medium opacity-90 mb-1">Total Envois</div>
                <div class="text-4xl font-black">{{ $stats['total_envois'] }}</div>
            </div>

            <div class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-4xl">💰</div>
                </div>
                <div class="text-sm font-medium opacity-90 mb-1">Total dépensé</div>
                <div class="text-4xl font-black">{{ number_format($stats['total_depense'], 0) }}€</div>
            </div>

            <div class="bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-4xl">⏳</div>
                </div>
                <div class="text-sm font-medium opacity-90 mb-1">En cours</div>
                <div class="text-4xl font-black">{{ $stats['en_cours'] }}</div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-4xl">✅</div>
                </div>
                <div class="text-sm font-medium opacity-90 mb-1">Livrés</div>
                <div class="text-4xl font-black">{{ $stats['livres'] }}</div>
            </div>
        </div>

        <!-- MES ENVOIS -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 mb-8">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-black text-gray-900">📦 Mes Envois</h2>
                    <p class="text-sm text-gray-600 mt-0.5">Suivez tous vos colis en temps réel</p>
                </div>
                <a href="{{ route('envois.create') }}" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-lg font-bold hover:shadow-lg transition">
                    ➕ Nouvel Envoi
                </a>
            </div>

            @if($envois->isEmpty())
                <div class="py-20 text-center">
                    <div class="text-8xl mb-4">📦</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Aucun envoi pour le moment</h3>
                    <p class="text-gray-600 mb-6">Créez votre premier envoi maintenant !</p>
                    <a href="{{ route('envois.create') }}" class="inline-block px-8 py-4 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-lg font-bold hover:shadow-xl transition">
                        ➕ Créer mon premier envoi
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">N° Suivi</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Route</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Poids</th>
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
                                    <div class="text-xs text-gray-500">🇫🇷 France → 🇧🇯 Bénin</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-bold text-gray-900">{{ $envoi->poids_kg }} kg</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="font-black text-green-600 text-lg">{{ number_format($envoi->prix_total, 2) }}€</span>
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
            @endif
        </div>

        <!-- ACTIONS RAPIDES -->
        <div>
            <h2 class="text-xl font-black text-gray-900 mb-4">⚡ Actions Rapides</h2>
            <div class="grid grid-cols-4 gap-4">
                <!-- CRÉER UN ENVOI -->
                <a href="{{ route('envois.create') }}" class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-xl p-6 hover:shadow-xl transition text-center group">
                    <div class="text-5xl mb-3 group-hover:scale-110 transition">➕</div>
                    <div class="font-bold">Créer un envoi</div>
                </a>

                <!-- SUIVRE UN COLIS -->
                <a href="{{ route('tracking') }}" class="bg-gradient-to-br from-cyan-500 to-blue-600 text-white rounded-xl p-6 hover:shadow-xl transition text-center group">
                    <div class="text-5xl mb-3 group-hover:scale-110 transition">🔍</div>
                    <div class="font-bold">Suivre un colis</div>
                </a>

                <!-- TOUS MES ENVOIS -->
                <a href="{{ route('envois.liste') }}" class="bg-gradient-to-br from-pink-500 to-rose-600 text-white rounded-xl p-6 hover:shadow-xl transition text-center group">
                    <div class="text-5xl mb-3 group-hover:scale-110 transition">📦</div>
                    <div class="font-bold">Tous mes envois</div>
                </a>

                <!-- NOUS CONTACTER -->
                <a href="mailto:contact@fmexpress.com" class="bg-gradient-to-br from-green-500 to-emerald-600 text-white rounded-xl p-6 hover:shadow-xl transition text-center group">
                    <div class="text-5xl mb-3 group-hover:scale-110 transition">📧</div>
                    <div class="font-bold">Nous contacter</div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection