@extends('layouts.admin-navbar')

@section('title', 'Client ' . $client->full_name . ' - FMEXPRESS')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <!-- HEADER -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-gray-900">👤 Détails du client</h1>
            <p class="text-gray-600 mt-1">Informations et historique</p>
        </div>
        <a href="{{ route('admin.clients') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-bold hover:bg-gray-300 transition">
            ← Retour
        </a>
    </div>

    <!-- INFORMATIONS CLIENT -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-8 mb-8">
        <div class="flex items-center gap-6 mb-6">
            <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-4xl font-black">
                {{ strtoupper(substr($client->prenom, 0, 1)) }}{{ strtoupper(substr($client->nom, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-3xl font-black text-gray-900">{{ $client->full_name }}</h2>
                <p class="text-gray-600 mt-1">Client depuis le {{ $client->created_at->format('d/m/Y') }}</p>
                <p class="text-sm text-gray-500 mt-1">ID: {{ $client->id }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <div class="text-sm text-gray-600 mb-1">Email</div>
                <div class="font-bold text-gray-900">{{ $client->email }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-600 mb-1">Téléphone</div>
                <div class="font-bold text-gray-900">{{ $client->telephone ?? 'Non renseigné' }}</div>
            </div>
        </div>
    </div>

    <!-- STATISTIQUES -->
    <div class="grid grid-cols-3 gap-6 mb-8">
        <!-- TOTAL ENVOIS -->
        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl p-6 text-white shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <div class="text-5xl">📦</div>
                <div class="text-right">
                    <div class="text-4xl font-black">{{ $stats['total_envois'] }}</div>
                    <div class="text-sm opacity-90">envois</div>
                </div>
            </div>
            <div class="text-sm opacity-90">Total des envois</div>
        </div>

        <!-- CA TOTAL -->
        <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl p-6 text-white shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <div class="text-5xl">💰</div>
                <div class="text-right">
                    <div class="text-4xl font-black">{{ number_format($stats['ca_total'], 0) }}€</div>
                    <div class="text-sm opacity-90">chiffre d'affaires</div>
                </div>
            </div>
            <div class="text-sm opacity-90">Total dépensé</div>
        </div>

        <!-- DERNIER ENVOI -->
        <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl p-6 text-white shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <div class="text-5xl">📅</div>
                <div class="text-right">
                    @if($stats['dernier_envoi'])
                        <div class="text-2xl font-black">{{ $stats['dernier_envoi']->diffForHumans() }}</div>
                        <div class="text-sm opacity-90">dernier envoi</div>
                    @else
                        <div class="text-2xl font-black">Jamais</div>
                        <div class="text-sm opacity-90">aucun envoi</div>
                    @endif
                </div>
            </div>
            <div class="text-sm opacity-90">
                @if($stats['dernier_envoi'])
                    {{ $stats['dernier_envoi']->format('d/m/Y') }}
                @else
                    Aucun envoi enregistré
                @endif
            </div>
        </div>
    </div>

    <!-- HISTORIQUE DES ENVOIS -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-black text-gray-900">📦 Historique des envois ({{ $envois->count() }})</h2>
        </div>

        @if($envois->isEmpty())
            <div class="py-20 text-center">
                <div class="text-8xl mb-4">📦</div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Aucun envoi</h3>
                <p class="text-gray-600">Ce client n'a pas encore créé d'envoi</p>
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
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Prix</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Statut</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Paiement</th>
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
                                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold">
                                    {{ $envoi->lignes->count() }} article(s)
                                </span>
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
                                    $statusLabels = [
                                        'EN_ATTENTE_CONFIRMATION' => 'En attente',
                                        'CONFIRMEE' => 'Confirmée',
                                        'RECUPERE' => 'Récupéré',
                                        'EN_PREPARATION' => 'En préparation',
                                        'EN_TRANSIT' => 'En transit',
                                        'ARRIVE_BENIN' => 'Arrivé',
                                        'EN_LIVRAISON' => 'En livraison',
                                        'LIVRE' => 'Livré',
                                        'ANNULEE' => 'Annulé',
                                    ];
                                    $color = $statusColors[$envoi->statut] ?? 'bg-gray-500';
                                    $label = $statusLabels[$envoi->statut] ?? $envoi->statut;
                                @endphp
                                <span class="px-3 py-1 {{ $color }} text-white rounded-full text-xs font-bold">
                                    {{ $label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $paiementColors = [
                                        'EN_ATTENTE' => 'bg-yellow-100 text-yellow-800',
                                        'PAYE' => 'bg-green-100 text-green-800',
                                        'REMBOURSE' => 'bg-blue-100 text-blue-800',
                                    ];
                                    $paiementColor = $paiementColors[$envoi->statut_paiement] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-3 py-1 {{ $paiementColor }} rounded-full text-xs font-bold">
                                    {{ $envoi->statut_paiement }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">
                                {{ $envoi->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.envois.show', $envoi->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-bold hover:bg-blue-700 transition">
                                    👁️ Voir
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- RÉSUMÉ FINANCIER -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="font-bold text-gray-700">Résumé financier</div>
                    <div class="flex items-center gap-8">
                        <div>
                            <div class="text-xs text-gray-600">Panier moyen</div>
                            <div class="text-lg font-black text-gray-900">
                                {{ $envois->count() > 0 ? number_format($stats['ca_total'] / $envois->count(), 2) : 0 }}€
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-gray-600">Total généré</div>
                            <div class="text-2xl font-black text-green-600">{{ number_format($stats['ca_total'], 2) }}€</div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection