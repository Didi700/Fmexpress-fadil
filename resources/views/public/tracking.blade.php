<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivre mon colis - FMEXPRESS</title>
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
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg font-bold hover:bg-green-700 transition">
                            Inscription
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <div class="max-w-2xl mx-auto px-6 py-16">
        <!-- TITRE -->
        <div class="text-center mb-12">
            <div class="text-8xl mb-6">📦</div>
            <h1 class="text-4xl font-black text-gray-900 mb-4">Suivez votre colis en temps réel</h1>
            <p class="text-gray-600 text-lg">Entrez votre numéro de suivi pour voir où se trouve votre envoi</p>
        </div>

        <!-- FORMULAIRE DE RECHERCHE -->
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 p-8">
            @if ($errors->any())
            <div class="mb-6 bg-red-100 border-2 border-red-500 rounded-xl p-4">
                <p class="text-red-800 font-bold text-center">{{ $errors->first() }}</p>
            </div>
            @endif

            <form method="POST" action="{{ route('tracking.search') }}">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-3">Numéro de suivi</label>
                    <input 
                        type="text" 
                        name="numero_suivi" 
                        value="{{ old('numero_suivi') }}"
                        class="w-full px-6 py-4 border-2 border-gray-300 rounded-xl text-center text-xl font-mono font-bold focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition uppercase"
                        placeholder="FME-XXXXXXXXX"
                        maxlength="15"
                        required
                        autofocus
                    >
                    <p class="text-xs text-gray-500 mt-2 text-center">Format : FME-XXXXXXXXX (15 caractères)</p>
                </div>

                <button 
                    type="submit"
                    class="w-full py-4 bg-gradient-to-r from-blue-600 to-green-600 text-white font-black text-lg rounded-xl hover:shadow-2xl transition transform hover:scale-105"
                >
                    🔍 Suivre mon colis
                </button>
            </form>
        </div>

        <!-- INFO SUPPLÉMENTAIRE -->
        <div class="mt-12 grid grid-cols-3 gap-4">
            <div class="bg-white rounded-xl p-6 text-center shadow-lg border border-gray-200">
                <div class="text-4xl mb-3">✈️</div>
                <div class="font-bold text-gray-900 text-sm">Livraison Express</div>
                <div class="text-xs text-gray-600 mt-1">7-10 jours</div>
            </div>

            <div class="bg-white rounded-xl p-6 text-center shadow-lg border border-gray-200">
                <div class="text-4xl mb-3">🚀</div>
                <div class="font-bold text-gray-900 text-sm">Livraison Urgente</div>
                <div class="text-xs text-gray-600 mt-1">3-5 jours</div>
            </div>

            <div class="bg-white rounded-xl p-6 text-center shadow-lg border border-gray-200">
                <div class="text-4xl mb-3">🛡️</div>
                <div class="font-bold text-gray-900 text-sm">Assurance optionnelle</div>
                <div class="text-xs text-gray-600 mt-1">Protection totale</div>
            </div>
        </div>

        <!-- EXEMPLE -->
        <div class="mt-8 p-4 bg-blue-50 border-2 border-blue-200 rounded-xl">
            <div class="flex items-center gap-3">
                <div class="text-2xl">💡</div>
                <div>
                    <div class="font-bold text-blue-900 text-sm">Où trouver mon numéro de suivi ?</div>
                    <div class="text-xs text-blue-700 mt-1">Votre numéro de suivi vous a été envoyé par email après la création de votre envoi.</div>
                </div>
            </div>
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