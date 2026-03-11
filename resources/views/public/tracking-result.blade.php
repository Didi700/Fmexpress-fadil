<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi {{ $envoi->numero_suivi }} - FMEXPRESS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-green-50 min-h-screen">
    <!-- HEADER -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <!-- BOUTON RETOUR INTELLIGENT -->
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 transition" title="Retour au dashboard">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 transition" title="Retour à l'accueil">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </a>
                    @endauth

                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="FMEXPRESS" class="w-12 h-12 rounded-lg">
                        <div>
                            <div class="font-black text-xl text-gray-900">FMEXPRESS</div>
                            <div class="text-xs text-gray-600 font-semibold">🇫🇷 Le Pont des Nations 🇧🇯</div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('tracking') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-bold hover:bg-gray-300 transition">
                        🔍 Nouvelle recherche
                    </a>
                    
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition">
                            🏠 Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button class="px-4 py-2 bg-red-500 text-white rounded-lg font-bold hover:bg-red-600 transition">
                                🚪 Déconnexion
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition">
                            Connexion
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <div class="max-w-4xl mx-auto px-6 py-8">
        <!-- NUMÉRO DE SUIVI -->
        <div class="text-center mb-8">
            <div class="text-sm text-gray-600 mb-2">Suivi de votre colis</div>
            <div class="text-3xl font-black text-gray-900 font-mono">{{ $envoi->numero_suivi }}</div>
        </div>

        <!-- STATUT ACTUEL -->
        <div class="bg-gradient-to-r from-blue-600 to-green-600 rounded-2xl shadow-2xl p-8 text-white mb-8">
            <div class="text-center">
                <div class="text-sm font-medium opacity-90 mb-3">Statut actuel</div>
                <div class="text-6xl font-black mb-4">{{ $envoi->status_label }}</div>
                <div class="text-sm opacity-90">Dernière mise à jour : {{ $envoi->updated_at->format('d/m/Y à H:i') }}</div>
            </div>
        </div>

        <!-- TIMELINE -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8">
            <h3 class="text-lg font-black text-gray-900 mb-6">📍 Historique du colis</h3>
            
            @php
                $etapes = [
                    'EN_ATTENTE_CONFIRMATION' => ['label' => 'En attente de confirmation', 'icon' => '⏳', 'color' => 'yellow'],
                    'CONFIRMEE' => ['label' => 'Confirmée', 'icon' => '✅', 'color' => 'blue'],
                    'RECUPERE' => ['label' => 'Récupéré', 'icon' => '📦', 'color' => 'purple'],
                    'EN_PREPARATION' => ['label' => 'En préparation', 'icon' => '🔧', 'color' => 'orange'],
                    'EN_TRANSIT' => ['label' => 'En transit', 'icon' => '✈️', 'color' => 'indigo'],
                    'ARRIVE_BENIN' => ['label' => 'Arrivé au Bénin', 'icon' => '🇧🇯', 'color' => 'cyan'],
                    'EN_LIVRAISON' => ['label' => 'En livraison', 'icon' => '🚚', 'color' => 'teal'],
                    'LIVRE' => ['label' => 'Livré', 'icon' => '✅', 'color' => 'green'],
                ];

                $currentIndex = array_search($envoi->statut, array_keys($etapes));
            @endphp

            <div class="space-y-4">
                @foreach($etapes as $statut => $info)
                    @php
                        $index = array_search($statut, array_keys($etapes));
                        $isActive = $index <= $currentIndex;
                        $isCurrent = $statut === $envoi->statut;
                    @endphp

                    <div class="flex items-center gap-4 {{ $isActive ? '' : 'opacity-30' }}">
                        <div class="w-12 h-12 rounded-full {{ $isActive ? 'bg-' . $info['color'] . '-500' : 'bg-gray-300' }} flex items-center justify-center text-white text-2xl {{ $isCurrent ? 'ring-4 ring-' . $info['color'] . '-300 scale-110' : '' }} transition">
                            {{ $info['icon'] }}
                        </div>
                        <div class="flex-1">
                            <div class="font-bold text-gray-900 {{ $isCurrent ? 'text-lg' : 'text-sm' }}">
                                {{ $info['label'] }}
                            </div>
                            @if($isCurrent)
                                <div class="text-xs text-{{ $info['color'] }}-600 font-semibold">En cours</div>
                            @endif
                        </div>
                        @if($isActive)
                            <div class="text-green-600 text-2xl">✓</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- INFORMATIONS DE L'ENVOI -->
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
                        <div class="text-gray-600 text-xs">Ville</div>
                        <div class="font-bold text-gray-900">{{ $envoi->destinataire_ville }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DÉTAILS COLIS -->
        @if($envoi->lignes && $envoi->lignes->count() > 0)
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8">
            <h3 class="text-lg font-black text-gray-900 mb-4">📦 Contenu du colis ({{ $envoi->lignes->count() }} articles)</h3>
            <div class="space-y-2">
                @foreach($envoi->lignes as $ligne)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <div class="font-bold text-gray-900 text-sm">{{ $ligne->getCategorieLabel() }}</div>
                        <div class="text-xs text-gray-600">Quantité : {{ $ligne->quantite }} • Poids : {{ number_format($ligne->poids_total, 2) }}kg</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- INFORMATIONS SUPPLÉMENTAIRES -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8">
            <h3 class="text-lg font-black text-gray-900 mb-4">ℹ️ Informations</h3>
            <div class="grid grid-cols-3 gap-4">
                <div class="text-center">
                    <div class="text-xs text-gray-600 mb-1">Poids total</div>
                    <div class="font-black text-xl text-gray-900">{{ $envoi->poids_kg }} kg</div>
                </div>
                <div class="text-center">
                    <div class="text-xs text-gray-600 mb-1">Mode de livraison</div>
                    <div class="font-black text-xl text-gray-900">{{ $envoi->mode_livraison }}</div>
                </div>
                <div class="text-center">
                    <div class="text-xs text-gray-600 mb-1">Date de création</div>
                    <div class="font-black text-xl text-gray-900">{{ $envoi->created_at->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>

        <!-- BOUTONS D'ACTION -->
        <div class="grid grid-cols-2 gap-4">
            @auth
                <a href="{{ route('dashboard') }}" class="py-4 bg-gray-200 text-gray-700 rounded-xl font-bold text-center hover:bg-gray-300 transition">
                    🏠 Retour au dashboard
                </a>
            @else
                <a href="{{ route('home') }}" class="py-4 bg-gray-200 text-gray-700 rounded-xl font-bold text-center hover:bg-gray-300 transition">
                    🏠 Retour à l'accueil
                </a>
            @endauth
            
            <a href="{{ route('tracking') }}" class="py-4 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-xl font-bold text-center hover:shadow-xl transition">
                🔍 Suivre un autre colis
            </a>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-6 py-8 text-center">
            <div class="text-gray-600 text-sm">
                © {{ date('Y') }} FMEXPRESS - Le Pont des Nations 🇫🇷 ⟷ 🇧🇯
            </div>
        </div>
    </footer>
</body>
</html>