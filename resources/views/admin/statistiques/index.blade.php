<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - FMEXPRESS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <!-- TOP NAVBAR -->
    <nav class="bg-gradient-to-r from-blue-600 to-green-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between h-16">
                <!-- LOGO + MENU -->
                <div class="flex items-center gap-8">
                    <!-- LOGO -->
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="FMEXPRESS" class="w-10 h-10 rounded-lg">
                        <span class="font-black text-lg">FMEXPRESS</span>
                    </div>

                    <!-- MENU -->
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg hover:bg-white/10 transition">
                            🏠 Dashboard
                        </a>
                        <a href="{{ route('admin.envois') }}" class="px-4 py-2 rounded-lg hover:bg-white/10 transition">
                            📦 Envois
                        </a>
                        <a href="{{ route('admin.clients') }}" class="px-4 py-2 rounded-lg hover:bg-white/10 transition">
                            👥 Clients
                        </a>
                        <a href="{{ route('admin.statistiques') }}" class="px-4 py-2 rounded-lg bg-white/20">
                            📊 Statistiques
                        </a>
                        @if(Auth::user()->role === 'SUPER_ADMIN')
                        <a href="{{ route('admin.admins') }}" class="px-4 py-2 rounded-lg hover:bg-white/10 transition">
                            👨‍💼 Admins
                        </a>
                        @endif
                    </div>
                </div>

                <!-- USER + LOGOUT -->
                <div class="flex items-center gap-4">
                    <div class="text-right text-sm">
                        <div class="font-bold">{{ Auth::user()->full_name }}</div>
                        <div class="text-xs opacity-75">{{ Auth::user()->role }}</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="px-4 py-2 bg-red-500 hover:bg-red-600 rounded-lg transition text-sm font-bold">
                            🚪 Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- CONTENU PRINCIPAL -->
    <div class="max-w-7xl mx-auto px-6 py-8">
        <!-- HEADER -->
        <div class="mb-8">
            <h1 class="text-3xl font-black text-gray-900">📊 Statistiques Avancées</h1>
            <p class="text-gray-600 mt-1">Vue d'ensemble complète de l'activité</p>
        </div>

        <!-- FILTRES PÉRIODE -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8">
            <form method="GET" action="{{ route('admin.statistiques') }}" class="flex items-end gap-4" autocomplete="off">
                <div class="flex-1">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Période de début</label>
                    <input 
                        type="month" 
                        name="mois_debut" 
                        value="{{ $moisDebut }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        autocomplete="off"
                    >
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Période de fin</label>
                    <input 
                        type="month" 
                        name="mois_fin" 
                        value="{{ $moisFin }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        autocomplete="off"
                    >
                </div>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-lg font-bold hover:shadow-lg transition">
                    📊 Mettre à jour
                </button>
                <a href="{{ route('admin.statistiques') }}" class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-bold hover:bg-gray-300 transition">
                    🔄 Réinitialiser
                </a>
            </form>
        </div>

        <!-- STATISTIQUES GLOBALES -->
        <div class="grid grid-cols-5 gap-4 mb-8">
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
                <div class="text-sm font-medium opacity-90 mb-2">Total Envois</div>
                <div class="text-4xl font-black">{{ number_format($statsGlobales['total_envois']) }}</div>
            </div>

            <div class="bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl p-6 text-white shadow-lg">
                <div class="text-sm font-medium opacity-90 mb-2">Clients</div>
                <div class="text-4xl font-black">{{ number_format($statsGlobales['total_clients']) }}</div>
            </div>

            <div class="bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
                <div class="text-sm font-medium opacity-90 mb-2">Revenu Total</div>
                <div class="text-4xl font-black">{{ number_format($statsGlobales['revenu_total'], 0) }}€</div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl p-6 text-white shadow-lg">
                <div class="text-sm font-medium opacity-90 mb-2">Panier Moyen</div>
                <div class="text-4xl font-black">{{ number_format($statsGlobales['panier_moyen'], 0) }}€</div>
            </div>

            <div class="bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl p-6 text-white shadow-lg">
                <div class="text-sm font-medium opacity-90 mb-2">Poids Total</div>
                <div class="text-4xl font-black">{{ number_format($statsGlobales['poids_total'], 0) }} kg</div>
            </div>
        </div>

        <!-- GRAPHIQUE -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-8">
            <h3 class="text-xl font-black text-gray-900 mb-6">📈 Évolution des revenus et envois</h3>
            <div style="height: 300px;">
                <canvas id="revenusChart"></canvas>
            </div>
        </div>

        <!-- GRILLE 2 COLONNES -->
        <div class="grid grid-cols-2 gap-6 mb-8">
            <!-- STATS PAR STATUT -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <h3 class="text-xl font-black text-gray-900 mb-6">📊 Par statut</h3>
                <div class="space-y-3">
                    @foreach($statsParStatut as $stat)
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
                        $color = $statusColors[$stat->statut] ?? 'bg-gray-500';
                    @endphp
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-4 h-4 {{ $color }} rounded-full"></div>
                            <span class="font-bold text-sm">{{ $stat->nombre }} envois</span>
                        </div>
                        <span class="text-sm font-bold text-gray-600">{{ number_format($stat->revenu, 0) }}€</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- STATS PAR MODE -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
                <h3 class="text-xl font-black text-gray-900 mb-6">⚡ Par mode</h3>
                <div class="space-y-4">
                    @foreach($statsParMode as $stat)
                    <div class="p-4 {{ $stat->mode_livraison == 'EXPRESS' ? 'bg-blue-50' : 'bg-red-50' }} rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-black text-lg">{{ $stat->mode_livraison }}</div>
                                <div class="text-sm text-gray-600">{{ $stat->nombre }} envois</div>
                            </div>
                            <div class="text-2xl font-black {{ $stat->mode_livraison == 'EXPRESS' ? 'text-blue-600' : 'text-red-600' }}">
                                {{ number_format($stat->revenu, 0) }}€
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- TOP CLIENTS -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
            <h3 class="text-xl font-black text-gray-900 mb-6">🏆 Top 5 Clients</h3>
            <div class="space-y-3">
                @foreach($topClients as $index => $client)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 {{ $index == 0 ? 'bg-yellow-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center text-white font-black">
                            {{ $index + 1 }}
                        </div>
                        <div>
                            <div class="font-bold">{{ $client->full_name }}</div>
                            <div class="text-sm text-gray-600">{{ $client->envois_count }} envois</div>
                        </div>
                    </div>
                    <div class="text-xl font-black text-green-600">
                        {{ number_format($client->envois_sum_prix_total ?? 0, 0) }}€
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- CHART.JS -->
    <script>
    const ctx = document.getElementById('revenusChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [
                {
                    label: 'Revenus (€)',
                    data: @json($dataRevenus),
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Envois',
                    data: @json($dataEnvois),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'top' }
            }
        }
    });
    </script>
</body>
</html>