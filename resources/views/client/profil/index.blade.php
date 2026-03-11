@extends('layouts.app')

@section('title', 'Mon Profil - FMEXPRESS')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-green-50">
    <!-- HEADER -->
    <header class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="FMEXPRESS" class="w-12 h-12 rounded-lg">
                    <div>
                        <div class="font-black text-xl text-gray-900">FMEXPRESS</div>
                        <div class="text-xs text-gray-600 font-semibold">🇫🇷 Le Pont des Nations 🇧🇯</div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-bold hover:bg-gray-300 transition">
                        ← Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-bold transition">
                            🚪 Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-6 py-8">
        <!-- TITRE -->
        <div class="mb-8">
            <h1 class="text-3xl font-black text-gray-900 mb-2">👤 Mon Profil</h1>
            <p class="text-gray-600">Gérez vos informations personnelles</p>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-100 border-2 border-green-500 rounded-xl p-4">
            <div class="flex items-center gap-3">
                <div class="text-3xl">✅</div>
                <div class="font-bold text-green-800">{{ session('success') }}</div>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 bg-red-100 border-2 border-red-500 rounded-xl p-4">
            <h3 class="font-bold text-red-800 mb-2">❌ Erreurs :</h3>
            <ul class="list-disc list-inside text-red-700 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- INFORMATIONS PERSONNELLES -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-6">
            <h2 class="text-xl font-black text-gray-900 mb-6">📝 Informations personnelles</h2>

            <form method="POST" action="{{ route('profil.update') }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Prénom *</label>
                        <input 
                            type="text" 
                            name="prenom" 
                            value="{{ old('prenom', $user->prenom) }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nom *</label>
                        <input 
                            type="text" 
                            name="nom" 
                            value="{{ old('nom', $user->nom) }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Email *</label>
                        <input 
                            type="email" 
                            name="email" 
                            value="{{ old('email', $user->email) }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Téléphone</label>
                        <input 
                            type="tel" 
                            name="telephone" 
                            value="{{ old('telephone', $user->telephone) }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition"
                            placeholder="+33 6 12 34 56 78"
                        >
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-600 to-green-600 text-white font-bold rounded-lg hover:shadow-xl transition">
                        ✅ Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>

        <!-- CHANGER LE MOT DE PASSE -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6">
            <h2 class="text-xl font-black text-gray-900 mb-6">🔒 Changer le mot de passe</h2>

            <form method="POST" action="{{ route('profil.password') }}">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Mot de passe actuel *</label>
                        <input 
                            type="password" 
                            name="current_password" 
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nouveau mot de passe *</label>
                        <input 
                            type="password" 
                            name="password" 
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition"
                            required
                            minlength="6"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Confirmer le nouveau mot de passe *</label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition"
                            required
                            minlength="6"
                        >
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full py-3 bg-gradient-to-r from-orange-500 to-red-600 text-white font-bold rounded-lg hover:shadow-xl transition">
                        🔒 Changer le mot de passe
                    </button>
                </div>
            </form>
        </div>

        <!-- STATISTIQUES PERSONNELLES -->
        <div class="mt-6 grid grid-cols-3 gap-4">
            <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200 text-center">
                <div class="text-4xl mb-2">📦</div>
                <div class="text-sm text-gray-600">Total envois</div>
                <div class="text-3xl font-black text-gray-900">{{ $user->envois()->count() }}</div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200 text-center">
                <div class="text-4xl mb-2">✅</div>
                <div class="text-sm text-gray-600">Livrés</div>
                <div class="text-3xl font-black text-green-600">{{ $user->envois()->where('statut', 'LIVRE')->count() }}</div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200 text-center">
                <div class="text-4xl mb-2">💰</div>
                <div class="text-sm text-gray-600">Total dépensé</div>
                <div class="text-3xl font-black text-blue-600">{{ number_format($user->envois()->sum('prix_total'), 0) }}€</div>
            </div>
        </div>
    </div>
</div>
@endsection