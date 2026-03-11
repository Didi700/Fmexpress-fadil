@extends('layouts.admin-navbar')

@section('title', 'Administrateurs - FMEXPRESS')

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

    @if($errors->any())
    <div class="mb-6 bg-red-100 border-2 border-red-500 rounded-xl p-4">
        <div class="flex items-center gap-3">
            <div class="text-3xl">❌</div>
            <div>
                <div class="font-bold text-red-800 mb-2">Erreur lors de la création</div>
                <ul class="list-disc list-inside text-sm text-red-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <!-- HEADER -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-gray-900">👨‍💼 Gestion des administrateurs</h1>
            <p class="text-gray-600 mt-1">{{ $admins->count() }} administrateur(s) actif(s)</p>
        </div>
        <button onclick="document.getElementById('modal-create').classList.remove('hidden')" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-lg font-bold hover:shadow-lg transition">
            ➕ Créer un administrateur
        </button>
    </div>

    <!-- STATISTIQUES -->
    <div class="grid grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <div class="text-3xl">👨‍💼</div>
                <div class="text-3xl font-black text-gray-900">{{ $admins->count() }}</div>
            </div>
            <div class="text-sm text-gray-600 font-semibold">Total admins</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <div class="text-3xl">⭐</div>
                <div class="text-3xl font-black text-purple-600">{{ $admins->where('role', 'SUPER_ADMIN')->count() }}</div>
            </div>
            <div class="text-sm text-gray-600 font-semibold">Super Admins</div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <div class="text-3xl">👔</div>
                <div class="text-3xl font-black text-blue-600">{{ $admins->where('role', 'ADMIN')->count() }}</div>
            </div>
            <div class="text-sm text-gray-600 font-semibold">Admins</div>
        </div>
    </div>

    <!-- LISTE DES ADMINS -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-black text-gray-900">Liste des administrateurs</h2>
        </div>

        @if($admins->isEmpty())
            <div class="py-20 text-center">
                <div class="text-8xl mb-4">👨‍💼</div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Aucun administrateur</h3>
                <p class="text-gray-600">Créez votre premier administrateur</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Administrateur</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Email</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Rôle</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Date création</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($admins as $admin)
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 {{ $admin->role == 'SUPER_ADMIN' ? 'bg-gradient-to-br from-purple-500 to-pink-600' : 'bg-gradient-to-br from-blue-500 to-cyan-600' }} rounded-full flex items-center justify-center text-white text-lg font-black">
                                        {{ strtoupper(substr($admin->prenom, 0, 1)) }}{{ strtoupper(substr($admin->nom, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900">{{ $admin->full_name }}</div>
                                        <div class="text-xs text-gray-500">ID: {{ $admin->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-900">{{ $admin->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($admin->role == 'SUPER_ADMIN')
                                    <span class="px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-600 text-white rounded-full text-sm font-bold">
                                        ⭐ SUPER ADMIN
                                    </span>
                                @else
                                    <span class="px-4 py-2 bg-blue-500 text-white rounded-full text-sm font-bold">
                                        👔 ADMIN
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-gray-700">
                                {{ $admin->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($admin->id != Auth::id())
                                    <form method="POST" action="{{ route('admin.admins.delete', $admin->id) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet administrateur ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg text-xs font-bold hover:bg-red-600 transition">
                                            🗑️ Supprimer
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-gray-500 italic">Vous-même</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- MODAL CRÉER ADMIN -->
<div id="modal-create" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4">
        <h3 class="text-2xl font-black text-gray-900 mb-6">➕ Créer un administrateur</h3>
        <form method="POST" action="{{ route('admin.admins.create') }}">
            @csrf
            
            <!-- PRÉNOM -->
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Prénom *</label>
                <input 
                    type="text" 
                    name="prenom" 
                    value="{{ old('prenom') }}"
                    required
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                    placeholder="Jean"
                >
            </div>

            <!-- NOM -->
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Nom *</label>
                <input 
                    type="text" 
                    name="nom" 
                    value="{{ old('nom') }}"
                    required
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                    placeholder="Dupont"
                >
            </div>

            <!-- EMAIL -->
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Email *</label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    required
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                    placeholder="admin@fmexpress.com"
                >
            </div>

            <!-- MOT DE PASSE -->
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Mot de passe *</label>
                <input 
                    type="password" 
                    name="password" 
                    required
                    minlength="6"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                    placeholder="••••••••"
                >
                <p class="text-xs text-gray-500 mt-1">Minimum 6 caractères</p>
            </div>

            <!-- RÔLE -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Rôle *</label>
                <div class="space-y-3">
                    <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                        <input type="radio" name="role" value="ADMIN" class="w-5 h-5" required checked>
                        <div>
                            <div class="font-bold text-gray-900">👔 Administrateur</div>
                            <div class="text-xs text-gray-600">Peut gérer les envois et clients</div>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-500 transition">
                        <input type="radio" name="role" value="SUPER_ADMIN" class="w-5 h-5" required>
                        <div>
                            <div class="font-bold text-gray-900">⭐ Super Administrateur</div>
                            <div class="text-xs text-gray-600">Accès total + gestion des admins</div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- BOUTONS -->
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('modal-create').classList.add('hidden')" class="flex-1 py-3 bg-gray-200 text-gray-700 rounded-lg font-bold hover:bg-gray-300 transition">
                    Annuler
                </button>
                <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-blue-600 to-green-600 text-white rounded-lg font-bold hover:shadow-lg transition">
                    ✅ Créer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection