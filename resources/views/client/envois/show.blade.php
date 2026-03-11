@extends('layouts.app')

@section('title', 'Envoi ' . $envoi->numero_suivi)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-green-50 py-8">
    <div class="max-w-4xl mx-auto px-6">
        <!-- SUCCESS MESSAGE -->
        @if(session('success'))
        <div class="mb-8 bg-green-100 border-2 border-green-500 rounded-2xl p-6">
            <div class="flex items-center gap-4">
                <div class="text-6xl">✅</div>
                <div>
                    <h2 class="text-2xl font-black text-green-800 mb-2">Envoi créé avec succès !</h2>
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- HEADER -->
        <div class="mb-8 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-gray-900">📦 Détails de l'envoi</h1>
                    <p class="text-gray-600 mt-1">Numéro de suivi : <span class="font-mono font-bold text-blue-600">{{ $envoi->numero_suivi }}</span></p>
                </div>
            </div>
        </div>

        <!-- STATUT -->
        <div class="mb-8 bg-gradient-to-r from-blue-600 to-green-600 rounded-2xl shadow-xl p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm font-medium opacity-90 mb-2">Statut actuel</div>
                    <div class="text-5xl font-black mb-4">{{ $envoi->status_label }}</div>
                    <div class="text-sm opacity-90">Dernière mise à jour : {{ $envoi->updated_at->diffForHumans() }}</div>
                </div>
                <div class="text-8xl">📦</div>
            </div>
        </div>

        <!-- ARTICLES ENVOYÉS -->
        @if($envoi->lignes && $envoi->lignes->count() > 0)
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8">
            <h3 class="text-lg font-black text-gray-900 mb-4">📦 Articles envoyés ({{ $envoi->lignes->count() }})</h3>
            <div class="space-y-3">
                @foreach($envoi->lignes as $ligne)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex-1">
                        <div class="font-bold text-gray-900">{{ $ligne->getCategorieLabel() }}</div>
                        <div class="text-sm text-gray-600 mt-1">
                            <span class="font-semibold">Quantité:</span> {{ $ligne->quantite }} 
                            <span class="ml-3 font-semibold">Poids:</span> {{ number_format($ligne->poids_total, 2) }} kg
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-black text-green-600">{{ number_format($ligne->prix_total, 2) }}€</div>
                        <div class="text-xs text-gray-500">{{ number_format($ligne->prix_unitaire, 2) }}€/{{ $ligne->quantite > 1 ? 'unité' : 'kg' }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- INFORMATIONS -->
        <div class="grid grid-cols-2 gap-6 mb-8">
            <!-- EXPÉDITEUR -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-xl">🇫🇷</div>
                    <h3 class="text-lg font-black text-gray-900">Expéditeur</h3>
                </div>
                <div class="space-y-2 text-sm">
                    <div>
                        <div class="text-gray-600 text-xs">Ville</div>
                        <div class="font-bold text-gray-900">{{ $envoi->expediteur_ville }}</div>
                    </div>
                    <div>
                        <div class="text-gray-600 text-xs">Adresse</div>
                        <div class="font-semibold text-gray-900">{{ $envoi->expediteur_adresse }}</div>
                    </div>
                    <div>
                        <div class="text-gray-600 text-xs">Code postal</div>
                        <div class="font-semibold text-gray-900">{{ $envoi->expediteur_code_postal }}</div>
                    </div>
                </div>
            </div>

            <!-- DESTINATAIRE -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-xl">🇧🇯</div>
                    <h3 class="text-lg font-black text-gray-900">Destinataire</h3>
                </div>
                <div class="space-y-2 text-sm">
                    <div>
                        <div class="text-gray-600 text-xs">Nom</div>
                        <div class="font-bold text-gray-900">{{ $envoi->destinataire_nom }}</div>
                    </div>
                    <div>
                        <div class="text-gray-600 text-xs">Téléphone</div>
                        <div class="font-semibold text-gray-900">{{ $envoi->destinataire_telephone }}</div>
                    </div>
                    <div>
                        <div class="text-gray-600 text-xs">Ville</div>
                        <div class="font-bold text-gray-900">{{ $envoi->destinataire_ville }}</div>
                    </div>
                    <div>
                        <div class="text-gray-600 text-xs">Adresse</div>
                        <div class="font-semibold text-gray-900">{{ $envoi->destinataire_adresse }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DÉTAILS COLIS -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8">
            <h3 class="text-lg font-black text-gray-900 mb-4">📦 Détails du colis</h3>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <div class="text-xs text-gray-600">Poids total</div>
                    <div class="text-lg font-bold text-gray-900">{{ $envoi->poids_kg }} kg</div>
                </div>
                <div>
                    <div class="text-xs text-gray-600">Mode de livraison</div>
                    <div class="text-lg font-bold text-gray-900">{{ $envoi->mode_livraison }}</div>
                </div>
                <div>
                    <div class="text-xs text-gray-600">Assurance</div>
                    <div class="text-lg font-bold {{ $envoi->assurance ? 'text-green-600' : 'text-red-600' }}">
                        {{ $envoi->assurance ? '✅ Oui' : '❌ Non' }}
                    </div>
                </div>
            </div>

            @if($envoi->description_contenu)
            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                <div class="text-xs text-gray-600 mb-1">Description</div>
                <div class="text-sm font-semibold text-gray-900">{{ $envoi->description_contenu }}</div>
            </div>
            @endif
        </div>

        <!-- TARIFICATION -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8">
            <h3 class="text-lg font-black text-gray-900 mb-4">💰 Tarification</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-700">Prix de base</span>
                    <span class="font-bold text-gray-900">{{ number_format($envoi->prix_base, 2) }}€</span>
                </div>
                @if($envoi->prix_assurance > 0)
                <div class="flex justify-between">
                    <span class="text-gray-700">Assurance</span>
                    <span class="font-bold text-gray-900">{{ number_format($envoi->prix_assurance, 2) }}€</span>
                </div>
                @endif
                <div class="border-t-2 border-gray-200 pt-3 flex justify-between items-center">
                    <span class="text-xl font-black text-gray-900">TOTAL</span>
                    <span class="text-4xl font-black text-green-600">{{ number_format($envoi->prix_total, 2) }}€</span>
                </div>
                <div class="flex items-center gap-2 justify-end">
                    <span class="text-sm text-gray-600">Statut paiement :</span>
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm font-bold">
                        {{ $envoi->statut_paiement }}
                    </span>
                </div>
            </div>
        </div>

        <!-- ACTIONS -->
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('dashboard') }}" class="py-4 bg-gray-200 text-gray-700 rounded-lg font-bold text-center hover:bg-gray-300 transition">
                ← Retour au dashboard
            </a>
            <a href="{{ route('envois.create') }}" class="py-4 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-lg font-bold text-center hover:shadow-xl transition">
                ➕ Créer un nouvel envoi
            </a>
        </div>
    </div>
</div>
@endsection