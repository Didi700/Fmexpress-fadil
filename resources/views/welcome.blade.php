<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FMEXPRESS - Le Pont des Nations 🇫🇷 ⟷ 🇧🇯</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
    <!-- HEADER -->
    <header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="FMEXPRESS" class="w-12 h-12 rounded-lg">
                    <div>
                        <div class="font-black text-xl text-gray-900">FMEXPRESS</div>
                        <div class="text-xs text-gray-600 font-semibold">🇫🇷 Le Pont des Nations 🇧🇯</div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('tracking') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-bold hover:bg-gray-200 transition">
                        📦 Suivre mon colis
                    </a>
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg font-bold hover:bg-green-700 transition">
                        Inscription
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="bg-gradient-to-br from-blue-50 via-white to-green-50 py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-6xl font-black text-gray-900 mb-6 leading-tight">
                        Envoyez vos colis entre la 
                        <span class="text-blue-600">France</span> et le 
                        <span class="text-green-600">Bénin</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8">
                        Livraison rapide, fiable et sécurisée. De 3 à 10 jours seulement !
                    </p>
                    <div class="flex gap-4">
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-green-600 text-white text-lg font-black rounded-xl hover:shadow-2xl transition transform hover:scale-105">
                            🚀 Créer mon envoi
                        </a>
                        <a href="{{ route('tracking') }}" class="px-8 py-4 bg-white border-2 border-gray-300 text-gray-900 text-lg font-black rounded-xl hover:bg-gray-50 transition">
                            📦 Suivre un colis
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400 to-green-400 rounded-3xl blur-3xl opacity-20"></div>
                    <div class="relative bg-white rounded-3xl shadow-2xl p-8 border-2 border-gray-200">
                        <div class="text-center mb-6">
                            <div class="text-8xl mb-4">📦</div>
                            <div class="text-2xl font-black text-gray-900">Livraison Express</div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-lg">
                                <div class="text-2xl">✈️</div>
                                <div class="font-bold text-blue-900">7-10 jours ouvrés</div>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-green-50 rounded-lg">
                                <div class="text-2xl">🚀</div>
                                <div class="font-bold text-green-900">3-5 jours ouvrés (Urgente)</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- AVANTAGES -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-gray-900 mb-4">Pourquoi choisir FMEXPRESS ?</h2>
                <p class="text-xl text-gray-600">Le service le plus rapide et fiable entre la France et le Bénin</p>
            </div>

            <div class="grid grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 text-center border-2 border-blue-200">
                    <div class="text-6xl mb-4">⚡</div>
                    <div class="font-black text-xl text-gray-900 mb-2">Rapide</div>
                    <div class="text-sm text-gray-600">Livraison en 3 à 10 jours seulement</div>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 text-center border-2 border-green-200">
                    <div class="text-6xl mb-4">🛡️</div>
                    <div class="font-black text-xl text-gray-900 mb-2">Sécurisé</div>
                    <div class="text-sm text-gray-600">Assurance optionnelle incluse</div>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 text-center border-2 border-purple-200">
                    <div class="text-6xl mb-4">📱</div>
                    <div class="font-black text-xl text-gray-900 mb-2">Suivi en temps réel</div>
                    <div class="text-sm text-gray-600">Suivez votre colis à chaque étape</div>
                </div>

                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-6 text-center border-2 border-orange-200">
                    <div class="text-6xl mb-4">💰</div>
                    <div class="font-black text-xl text-gray-900 mb-2">Prix compétitifs</div>
                    <div class="text-sm text-gray-600">Les meilleurs tarifs du marché</div>
                </div>
            </div>
        </div>
    </section>

    <!-- TARIFS -->
    <section class="py-20 bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-gray-900 mb-4">Nos Tarifs</h2>
                <p class="text-xl text-gray-600">Transparent et sans surprise</p>
            </div>

            <div class="grid grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- EXPRESS -->
                <div class="bg-white rounded-2xl shadow-2xl border-2 border-blue-200 p-8">
                    <div class="text-center mb-6">
                        <div class="text-6xl mb-4">✈️</div>
                        <div class="text-3xl font-black text-gray-900 mb-2">Express</div>
                        <div class="text-gray-600 font-semibold">7-10 jours ouvrés</div>
                    </div>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-2">
                            <div class="text-green-600 text-xl">✓</div>
                            <div>📱 Téléphone : 60€</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="text-green-600 text-xl">✓</div>
                            <div>💻 Ordinateur : 35€/kg</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="text-green-600 text-xl">✓</div>
                            <div>📦 Standard : 15€/kg</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="text-green-600 text-xl">✓</div>
                            <div>Suivi en temps réel</div>
                        </div>
                    </div>
                    <a href="{{ route('register') }}" class="mt-6 block w-full py-3 bg-blue-600 text-white font-bold rounded-lg text-center hover:bg-blue-700 transition">
                        Choisir Express
                    </a>
                </div>

                <!-- URGENTE -->
                <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl shadow-2xl border-2 border-red-300 p-8 text-white relative">
                    <div class="absolute -top-4 right-6 px-4 py-1 bg-yellow-400 text-gray-900 rounded-full text-xs font-black">
                        ⚡ PLUS RAPIDE
                    </div>
                    <div class="text-center mb-6">
                        <div class="text-6xl mb-4">🚀</div>
                        <div class="text-3xl font-black mb-2">Urgente</div>
                        <div class="font-semibold opacity-90">3-5 jours ouvrés</div>
                    </div>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-2">
                            <div class="text-yellow-300 text-xl">✓</div>
                            <div>+50% sur le prix Express</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="text-yellow-300 text-xl">✓</div>
                            <div>Priorité de traitement</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="text-yellow-300 text-xl">✓</div>
                            <div>Livraison ultra-rapide</div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="text-yellow-300 text-xl">✓</div>
                            <div>Suivi en temps réel</div>
                        </div>
                    </div>
                    <a href="{{ route('register') }}" class="mt-6 block w-full py-3 bg-white text-red-600 font-bold rounded-lg text-center hover:bg-gray-100 transition">
                        Choisir Urgente
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA FINAL -->
    <section class="py-20 bg-gradient-to-r from-blue-600 to-green-600 text-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-5xl font-black mb-6">Prêt à envoyer votre colis ?</h2>
            <p class="text-xl mb-8 opacity-90">Rejoignez des centaines de clients satisfaits</p>
            <a href="{{ route('register') }}" class="inline-block px-12 py-5 bg-white text-blue-600 text-xl font-black rounded-xl hover:shadow-2xl transition transform hover:scale-105">
                🚀 Créer mon compte gratuitement
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="FMEXPRESS" class="w-10 h-10 rounded-lg">
                        <div class="font-black text-lg">FMEXPRESS</div>
                    </div>
                    <p class="text-gray-400 text-sm">Le Pont des Nations entre la France et le Bénin</p>
                </div>

                <div>
                    <h3 class="font-bold mb-4">Services</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('tracking') }}" class="hover:text-white">Suivre un colis</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white">Créer un envoi</a></li>
                        <li><a href="#">Tarifs</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-bold mb-4">Compte</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('login') }}" class="hover:text-white">Connexion</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white">Inscription</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-bold mb-4">Contact</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>📧 contact@fmexpress.com</li>
                        <li>📱 +33 6 XX XX XX XX</li>
                        <li>🇫🇷 France • 🇧🇯 Bénin</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 text-center text-gray-400 text-sm">
                © {{ date('Y') }} FMEXPRESS - Tous droits réservés
            </div>
        </div>
    </footer>
</body>
</html>