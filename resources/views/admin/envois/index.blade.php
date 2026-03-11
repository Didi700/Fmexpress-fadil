@extends('layouts.admin-navbar')

@section('title', 'Envois - FMEXPRESS')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <!-- HEADER -->
    <div class="mb-8">
        <h1 class="text-3xl font-black text-gray-900">📦 Gestion des envois</h1>
        <p class="text-gray-600 mt-1">{{ $envois->count() }} envoi(s) au total</p>
    </div>

    <!-- STATISTIQUES -->
    <div class="grid grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <div class="text-3xl">📦</div>
                <div class="text-3xl font-black text-gray-900">{{ $envois->count() }}</div>
            </div>
            <div class="text-sm text-gray-600 font-semibold">Total envois</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <div class="text-3xl">⏳</div>
                <div class="text-3xl font-black text-yellow-600">{{ $envois->whereIn('statut', ['EN_ATTENTE_CONFIRMATION', 'CONFIRMEE'])->count() }}</div>
            </div>
            <div class="text-sm text-gray-600 font-semibold">En attente</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <div class="text-3xl">✈️</div>
                <div class="text-3xl font-black text-blue-600">{{ $envois->whereIn('statut', ['EN_TRANSIT', 'EN_PREPARATION', 'RECUPERE'])->count() }}</div>
            </div>
            <div class="text-sm text-gray-600 font-semibold">En transit</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <div class="text-3xl">✅</div>
                <div class="text-3xl font-black text-green-600">{{ $envois->where('statut', 'LIVRE')->count() }}</div>
            </div>
            <div class="text-sm text-gray-600 font-semibold">Livrés</div>
        </div>
    </div>

    <!-- LISTE DES ENVOIS -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-black text-gray-900">Liste complète des envois</h2>
        </div>

        @if($envois->isEmpty())
            <div class="py-20 text-center">
                <div class="text-8xl mb-4">📦</div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Aucun envoi pour le moment</h3>
                <p class="text-gray-600">Les envois apparaîtront ici dès qu'un client en créera</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">N° Suivi</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Client</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Route</th>
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
                                <div class="font-bold text-gray-900">{{ $envoi->user->full_name }}</div>
                                <div class="text-xs text-gray-500">{{ $envoi->user->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-sm text-gray-900">{{ $envoi->expediteur_ville }} → {{ $envoi->destinataire_ville }}</div>
                                <div class="text-xs text-gray-500">{{ $envoi->destinataire_nom }}</div>
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
        @endif
    </div>
</div>
@endsection