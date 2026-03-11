@extends('layouts.admin-navbar')

@section('title', 'Clients - FMEXPRESS')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">
    <!-- HEADER -->
    <div class="mb-8">
        <h1 class="text-3xl font-black text-gray-900">👥 Gestion des clients</h1>
        <p class="text-gray-600 mt-1">{{ $clients->count() }} client(s) inscrit(s)</p>
    </div>

    <!-- STATISTIQUES -->
    <div class="grid grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <div class="text-3xl">👥</div>
                <div class="text-3xl font-black text-gray-900">{{ $clients->count() }}</div>
            </div>
            <div class="text-sm text-gray-600 font-semibold">Total clients</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <div class="text-3xl">✅</div>
                <div class="text-3xl font-black text-green-600">{{ $clients->where('envois_count', '>', 0)->count() }}</div>
            </div>
            <div class="text-sm text-gray-600 font-semibold">Clients actifs</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <div class="text-3xl">🆕</div>
                <div class="text-3xl font-black text-blue-600">{{ $clients->where('created_at', '>=', now()->startOfMonth())->count() }}</div>
            </div>
            <div class="text-sm text-gray-600 font-semibold">Nouveaux ce mois</div>
        </div>
    </div>

    <!-- LISTE DES CLIENTS -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-black text-gray-900">Liste des clients</h2>
        </div>

        <!-- RECHERCHE -->
        <div class="px-6 py-4 border-b border-gray-200">
            <input 
                type="text" 
                id="searchInput"
                placeholder="🔍 Rechercher un client..."
                class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                autocomplete="off"
            >
        </div>

        @if($clients->isEmpty())
            <div class="py-20 text-center">
                <div class="text-8xl mb-4">👥</div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Aucun client pour le moment</h3>
                <p class="text-gray-600">Les clients apparaîtront ici après leur inscription</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Client</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Contact</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Envois</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">CA Total</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Inscription</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200" id="clientsTable">
                        @foreach($clients as $client)
                        <tr class="hover:bg-blue-50 transition client-row" data-search="{{ strtolower($client->full_name . ' ' . $client->email) }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-lg font-black">
                                        {{ strtoupper(substr($client->prenom, 0, 1)) }}{{ strtoupper(substr($client->nom, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900">{{ $client->full_name }}</div>
                                        <div class="text-xs text-gray-500">ID: {{ $client->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <div class="font-semibold text-gray-900">{{ $client->email }}</div>
                                    @if($client->telephone)
                                    <div class="text-gray-600">{{ $client->telephone }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-bold">
                                    {{ $client->envois_count }} envoi(s)
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-black text-green-600 text-lg">{{ number_format($client->envois_sum_prix_total ?? 0, 0) }}€</span>
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">
                                {{ $client->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.clients.show', $client->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition">
                                    Voir détails
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

<!-- SCRIPT DE RECHERCHE -->
<script>
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.client-row');
    
    rows.forEach(row => {
        const searchData = row.getAttribute('data-search');
        if (searchData.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>
@endsection