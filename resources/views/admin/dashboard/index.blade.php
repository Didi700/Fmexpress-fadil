@extends('layouts.admin-navbar')

@section('title', 'Dashboard Admin - FMEXPRESS')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <!-- HEADER -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-gray-900">🚀 Dashboard Super Administrateur</h1>
            <p class="text-gray-600 mt-1">Vue d'ensemble de FMEXPRESS</p>
        </div>
        <div class="text-right text-sm text-gray-600">
            {{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
        </div>
    </div>

    <!-- STATISTIQUES PRINCIPALES -->
    <div class="grid grid-cols-4 gap-6 mb-8">
        <!-- TOTAL ENVOIS -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-2xl">📦</div>
                <span class="text-green-600 text-sm font-bold">+12%</span>
            </div>
            <div class="text-sm text-gray-600 mb-1">Total des envois</div>
            <div class="text-4xl font-black text-gray-900">{{ $stats['total_envois'] }}</div>
            <div class="text-xs text-gray-500 mt-1">Depuis le début</div>
        </div>

        <!-- CHIFFRE D'AFFAIRES -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-2xl">💰</div>
            </div>
            <div class="text-sm text-gray-600 mb-1">Chiffre d'affaires</div>
            <div class="text-4xl font-black text-gray-900">{{ number_format($stats['revenu_total'], 0) }}€</div>
            <div class="text-xs text-gray-500 mt-1">Revenus totaux</div>
        </div>

        <!-- CA DU MOIS -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-2xl">📈</div>
                <span class="text-orange-600 text-sm font-bold">Dec</span>
            </div>
            <div class="text-sm text-gray-600 mb-1">CA du mois</div>
            <div class="text-4xl font-black text-gray-900">{{ number_format($stats['revenu_mois'], 0) }}€</div>
            <div class="text-xs text-gray-500 mt-1">décembre {{ date('Y') }}</div>
        </div>

        <!-- CLIENTS INSCRITS -->
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-2xl">👥</div>
            </div>
            <div class="text-sm text-gray-600 mb-1">Clients inscrits</div>
            <div class="text-4xl font-black text-gray-900">{{ $stats['total_clients'] }}</div>
            <div class="text-xs text-gray-500 mt-1">Base de données</div>
        </div>
    </div>

    <!-- STATUTS ENVOIS -->
    <div class="grid grid-cols-3 gap-6 mb-8">
        <!-- EN ATTENTE -->
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-200 rounded-2xl p-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-yellow-400 rounded-xl flex items-center justify-center text-2xl">⏳</div>
                <div>
                    <div class="text-sm text-yellow-700 font-semibold">En attente</div>
                    <div class="text-4xl font-black text-yellow-900">{{ $stats['en_attente'] }}</div>
                </div>
            </div>
        </div>

        <!-- EN TRANSIT -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-2xl p-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-blue-400 rounded-xl flex items-center justify-center text-2xl">✈️</div>
                <div>
                    <div class="text-sm text-blue-700 font-semibold">En transit</div>
                    <div class="text-4xl font-black text-blue-900">{{ $stats['en_transit'] }}</div>
                </div>
            </div>
        </div>

        <!-- LIVRÉS -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-2xl p-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-green-400 rounded-xl flex items-center justify-center text-2xl">✅</div>
                <div>
                    <div class="text-sm text-green-700 font-semibold">Livrés</div>
                    <div class="text-4xl font-black text-green-900">{{ $stats['livres'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- DERNIERS ENVOIS -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8">
        <div class="mb-6">
            <h2 class="text-xl font-black text-gray-900">📦 Derniers envois</h2>
            <p class="text-sm text-gray-600">Activité récente</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700">N° Suivi</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700">Client</th>
                        <th class="px-4 py-3 text-left text-xs font-bold text-gray-700">Route</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-700">Prix</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-700">Statut</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-700">Date</th>
                        <th class="px-4 py-3 text-center text-xs font-bold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($envois as $envoi)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            <span class="font-mono text-sm font-bold text-blue-600">{{ $envoi->numero_suivi }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-bold text-sm">{{ $envoi->user->full_name }}</div>
                            <div class="text-xs text-gray-500">{{ $envoi->user->email }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-bold text-sm">{{ $envoi->expediteur_ville }} → {{ $envoi->destinataire_ville }}</div>
                            <div class="text-xs text-gray-500">🇫🇷 France → 🇧🇯 Bénin</div>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="font-black text-green-600 text-lg">{{ number_format($envoi->prix_total, 2) }}€</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            @php
                                $statusBadges = [
                                    'EN_ATTENTE_CONFIRMATION' => ['bg' => 'bg-yellow-500', 'text' => 'En attente'],
                                    'CONFIRMEE' => ['bg' => 'bg-blue-500', 'text' => 'Confirmée'],
                                    'RECUPERE' => ['bg' => 'bg-purple-500', 'text' => 'Récupéré'],
                                    'EN_PREPARATION' => ['bg' => 'bg-orange-500', 'text' => 'En préparation'],
                                    'EN_TRANSIT' => ['bg' => 'bg-blue-600', 'text' => 'En transit'],
                                    'ARRIVE_BENIN' => ['bg' => 'bg-cyan-500', 'text' => 'Arrivé'],
                                    'EN_LIVRAISON' => ['bg' => 'bg-teal-500', 'text' => 'En livraison'],
                                    'LIVRE' => ['bg' => 'bg-green-500', 'text' => 'Livré'],
                                    'ANNULEE' => ['bg' => 'bg-red-500', 'text' => 'Annulé'],
                                ];
                                $badge = $statusBadges[$envoi->statut] ?? ['bg' => 'bg-gray-500', 'text' => $envoi->statut];
                            @endphp
                            <span class="px-3 py-1 {{ $badge['bg'] }} text-white rounded-full text-xs font-bold">
                                {{ $badge['text'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-700">
                            {{ $envoi->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('admin.envois.show', $envoi->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 transition">
                                Gérer
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- TOP 5 CLIENTS -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-black text-gray-900">🏆 Top 5 Clients</h2>
                <p class="text-sm text-gray-600">Meilleurs contributeurs</p>
            </div>
            <a href="{{ route('admin.clients') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition">
                Voir tous
            </a>
        </div>

        <div class="space-y-3">
            @php
                $topClients = \App\Models\User::where('role', 'CLIENT')
                    ->withSum('envois', 'prix_total')
                    ->withCount('envois')
                    ->orderBy('envois_sum_prix_total', 'desc')
                    ->take(5)
                    ->get();
            @endphp

            @foreach($topClients as $index => $client)
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 {{ $index == 0 ? 'bg-yellow-500' : ($index == 1 ? 'bg-orange-400' : ($index == 2 ? 'bg-orange-500' : 'bg-orange-400')) }} rounded-xl flex items-center justify-center text-white font-black text-lg">
                        {{ $index + 1 }}
                    </div>
                    <div>
                        <div class="font-bold text-gray-900">{{ $client->full_name }}</div>
                        <div class="text-sm text-gray-600">{{ $client->email }}</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-black text-green-600">{{ number_format($client->envois_sum_prix_total ?? 0, 2) }}€</div>
                    <div class="text-xs text-gray-600">{{ $client->envois_count }} envoi(s)</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ACTIONS RAPIDES -->
    <div class="mb-8">
        <h2 class="text-xl font-black text-gray-900 mb-4">⚡ Actions rapides</h2>
        <div class="grid grid-cols-4 gap-4">
            <!-- CRÉER ADMIN -->
            @if(Auth::user()->role === 'SUPER_ADMIN')
            <a href="{{ route('admin.admins') }}" class="bg-gradient-to-br from-purple-500 to-indigo-600 text-white rounded-xl p-6 hover:shadow-xl transition text-center group">
                <div class="text-5xl mb-3 group-hover:scale-110 transition">👨‍💼</div>
                <div class="font-bold">Gérer les admins</div>
            </a>
            @endif

            <!-- VOIR CLIENTS -->
            <a href="{{ route('admin.clients') }}" class="bg-gradient-to-br from-cyan-500 to-blue-600 text-white rounded-xl p-6 hover:shadow-xl transition text-center group">
                <div class="text-5xl mb-3 group-hover:scale-110 transition">👥</div>
                <div class="font-bold">Voir les clients</div>
            </a>

            <!-- GÉRER ENVOIS -->
            <a href="{{ route('admin.envois') }}" class="bg-gradient-to-br from-pink-500 to-rose-600 text-white rounded-xl p-6 hover:shadow-xl transition text-center group">
                <div class="text-5xl mb-3 group-hover:scale-110 transition">📦</div>
                <div class="font-bold">Gérer les envois</div>
            </a>

            <!-- STATISTIQUES -->
            <a href="{{ route('admin.statistiques') }}" class="bg-gradient-to-br from-green-500 to-emerald-600 text-white rounded-xl p-6 hover:shadow-xl transition text-center group">
                <div class="text-5xl mb-3 group-hover:scale-110 transition">📊</div>
                <div class="font-bold">Statistiques</div>
            </a>
        </div>
    </div>
</div>
@endsection