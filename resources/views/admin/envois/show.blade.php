@extends('layouts.admin-navbar')

@section('title', 'Envoi ' . $envoi->numero_suivi)

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    @if(session('success'))
    <div class="mb-6 bg-green-100 border-2 border-green-500 rounded-xl p-4">
        <div class="flex items-center gap-3">
            <div class="text-3xl">✅</div>
            <div class="font-bold text-green-800">{{ session('success') }}</div>
        </div>
    </div>
    @endif

    <!-- HEADER -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-gray-900">📦 Détails de l'envoi</h1>
            <p class="text-gray-600 mt-1">Numéro de suivi : <span class="font-mono font-bold text-blue-600">{{ $envoi->numero_suivi }}</span></p>
        </div>
        <a href="{{ route('admin.envois') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-bold hover:bg-gray-300 transition">
            ← Retour
        </a>
    </div>

    <!-- STATUT ET PAIEMENT -->
    <div class="grid grid-cols-2 gap-6 mb-8">
        <!-- STATUT ENVOI -->
        <div class="bg-gradient-to-r from-blue-600 to-green-600 rounded-2xl shadow-xl p-8 text-white">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <div class="text-sm font-medium opacity-90 mb-2">Statut de l'envoi</div>
                    <div class="text-4xl font-black">{{ $envoi->status_label }}</div>
                    <div class="text-sm opacity-90 mt-2">Dernière MAJ : {{ $envoi->updated_at->diffForHumans() }}</div>
                </div>
                <div class="text-6xl">📦</div>
            </div>
            <button onclick="document.getElementById('modal-statut').classList.remove('hidden')" class="w-full py-3 bg-white text-blue-600 rounded-lg font-bold hover:bg-gray-100 transition">
                🔄 Changer le statut
            </button>
        </div>

        <!-- STATUT PAIEMENT -->
        <div class="bg-white rounded-2xl shadow-xl border-2 border-gray-200 p-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <div class="text-sm font-semibold text-gray-600 mb-2">Statut de paiement</div>
                    @php
                        $paiementColors = [
                            'EN_ATTENTE' => 'bg-yellow-500',
                            'PAYE' => 'bg-green-500',
                            'REMBOURSE' => 'bg-blue-500',
                        ];
                        $paiementLabels = [
                            'EN_ATTENTE' => 'En attente',
                            'PAYE' => 'Payé',
                            'REMBOURSE' => 'Remboursé',
                        ];
                        $color = $paiementColors[$envoi->statut_paiement] ?? 'bg-gray-500';
                        $label = $paiementLabels[$envoi->statut_paiement] ?? $envoi->statut_paiement;
                    @endphp
                    <div class="inline-block px-6 py-3 {{ $color }} text-white rounded-xl text-2xl font-black">
                        {{ $label }}
                    </div>
                </div>
                <div class="text-6xl">💳</div>
            </div>
            <div class="mb-4">
                <div class="text-sm text-gray-600 mb-1">Montant total</div>
                <div class="text-4xl font-black text-green-600">{{ number_format($envoi->prix_total, 2) }}€</div>
            </div>
            <button onclick="document.getElementById('modal-paiement').classList.remove('hidden')" class="w-full py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg font-bold hover:shadow-lg transition">
                💰 Changer le statut de paiement
            </button>
        </div>
    </div>

    <!-- INFORMATIONS CLIENT -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8">
        <h3 class="text-lg font-black text-gray-900 mb-4">👤 Client</h3>
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-black">
                {{ strtoupper(substr($envoi->user->prenom, 0, 1)) }}{{ strtoupper(substr($envoi->user->nom, 0, 1)) }}
            </div>
            <div>
                <div class="font-bold text-gray-900 text-lg">{{ $envoi->user->full_name }}</div>
                <div class="text-sm text-gray-600">{{ $envoi->user->email }}</div>
                @if($envoi->user->telephone)
                <div class="text-sm text-gray-600">📱 {{ $envoi->user->telephone }}</div>
                @endif
            </div>
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

    <!-- INFORMATIONS ENVOI -->
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
        <div class="grid grid-cols-4 gap-4">
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
            <div>
                <div class="text-xs text-gray-600">Date de création</div>
                <div class="text-lg font-bold text-gray-900">{{ $envoi->created_at->format('d/m/Y') }}</div>
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
                <span class="text-gray-700">Assurance (2% de {{ number_format($envoi->valeur_declaree, 2) }}€)</span>
                <span class="font-bold text-gray-900">{{ number_format($envoi->prix_assurance, 2) }}€</span>
            </div>
            @endif
            <div class="border-t-2 border-gray-200 pt-3 flex justify-between items-center">
                <span class="text-xl font-black text-gray-900">TOTAL</span>
                <span class="text-4xl font-black text-green-600">{{ number_format($envoi->prix_total, 2) }}€</span>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CHANGER STATUT -->
<div id="modal-statut" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4">
        <h3 class="text-2xl font-black text-gray-900 mb-6">🔄 Changer le statut</h3>
        <form method="POST" action="{{ route('admin.envois.updateStatus', $envoi->id) }}">
            @csrf
            <div class="space-y-3 mb-6">
                <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-yellow-500 transition">
                    <input type="radio" name="statut" value="EN_ATTENTE_CONFIRMATION" class="w-5 h-5" {{ $envoi->statut == 'EN_ATTENTE_CONFIRMATION' ? 'checked' : '' }}>
                    <span class="font-bold">⏳ En attente de confirmation</span>
                </label>
                <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                    <input type="radio" name="statut" value="CONFIRMEE" class="w-5 h-5" {{ $envoi->statut == 'CONFIRMEE' ? 'checked' : '' }}>
                    <span class="font-bold">✅ Confirmée</span>
                </label>
                <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-500 transition">
                    <input type="radio" name="statut" value="RECUPERE" class="w-5 h-5" {{ $envoi->statut == 'RECUPERE' ? 'checked' : '' }}>
                    <span class="font-bold">📦 Récupéré</span>
                </label>
                <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-orange-500 transition">
                    <input type="radio" name="statut" value="EN_PREPARATION" class="w-5 h-5" {{ $envoi->statut == 'EN_PREPARATION' ? 'checked' : '' }}>
                    <span class="font-bold">🔧 En préparation</span>
                </label>
                <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-indigo-500 transition">
                    <input type="radio" name="statut" value="EN_TRANSIT" class="w-5 h-5" {{ $envoi->statut == 'EN_TRANSIT' ? 'checked' : '' }}>
                    <span class="font-bold">✈️ En transit</span>
                </label>
                <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-cyan-500 transition">
                    <input type="radio" name="statut" value="ARRIVE_BENIN" class="w-5 h-5" {{ $envoi->statut == 'ARRIVE_BENIN' ? 'checked' : '' }}>
                    <span class="font-bold">🇧🇯 Arrivé au Bénin</span>
                </label>
                <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-teal-500 transition">
                    <input type="radio" name="statut" value="EN_LIVRAISON" class="w-5 h-5" {{ $envoi->statut == 'EN_LIVRAISON' ? 'checked' : '' }}>
                    <span class="font-bold">🚚 En livraison</span>
                </label>
                <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-green-500 transition">
                    <input type="radio" name="statut" value="LIVRE" class="w-5 h-5" {{ $envoi->statut == 'LIVRE' ? 'checked' : '' }}>
                    <span class="font-bold">✅ Livré</span>
                </label>
                <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-red-500 transition">
                    <input type="radio" name="statut" value="ANNULEE" class="w-5 h-5" {{ $envoi->statut == 'ANNULEE' ? 'checked' : '' }}>
                    <span class="font-bold">❌ Annulée</span>
                </label>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('modal-statut').classList.add('hidden')" class="flex-1 py-3 bg-gray-200 text-gray-700 rounded-lg font-bold hover:bg-gray-300 transition">
                    Annuler
                </button>
                <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-lg font-bold hover:shadow-lg transition">
                    ✅ Valider
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL CHANGER PAIEMENT -->
<div id="modal-paiement" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4">
        <h3 class="text-2xl font-black text-gray-900 mb-6">💰 Changer le statut de paiement</h3>
        <form method="POST" action="{{ route('admin.envois.updatePaiement', $envoi->id) }}">
            @csrf
            <div class="space-y-3 mb-6">
                <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-yellow-500 transition">
                    <input type="radio" name="statut_paiement" value="EN_ATTENTE" class="w-5 h-5" {{ $envoi->statut_paiement == 'EN_ATTENTE' ? 'checked' : '' }}>
                    <div class="flex-1">
                        <div class="font-bold text-gray-900">⏳ En attente</div>
                        <div class="text-xs text-gray-600">Le paiement n'a pas encore été effectué</div>
                    </div>
                </label>
                <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-green-500 transition">
                    <input type="radio" name="statut_paiement" value="PAYE" class="w-5 h-5" {{ $envoi->statut_paiement == 'PAYE' ? 'checked' : '' }}>
                    <div class="flex-1">
                        <div class="font-bold text-gray-900">✅ Payé</div>
                        <div class="text-xs text-gray-600">Le paiement a été reçu et validé</div>
                    </div>
                </label>
                <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                    <input type="radio" name="statut_paiement" value="REMBOURSE" class="w-5 h-5" {{ $envoi->statut_paiement == 'REMBOURSE' ? 'checked' : '' }}>
                    <div class="flex-1">
                        <div class="font-bold text-gray-900">💵 Remboursé</div>
                        <div class="text-xs text-gray-600">Le montant a été remboursé au client</div>
                    </div>
                </label>
            </div>
            <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex items-center gap-2 mb-2">
                    <div class="text-2xl">💰</div>
                    <div class="font-bold text-blue-900">Montant de la transaction</div>
                </div>
                <div class="text-3xl font-black text-blue-600">{{ number_format($envoi->prix_total, 2) }}€</div>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('modal-paiement').classList.add('hidden')" class="flex-1 py-3 bg-gray-200 text-gray-700 rounded-lg font-bold hover:bg-gray-300 transition">
                    Annuler
                </button>
                <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg font-bold hover:shadow-lg transition">
                    ✅ Valider
                </button>
            </div>
        </form>
    </div>
</div>
@endsection