@extends('layouts.app')

@section('title', 'Inscription - FMEXPRESS')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-green-50 px-4 py-8">
    <div class="max-w-md w-full">
        <!-- LOGO -->
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="FMEXPRESS" class="w-24 h-24 mx-auto mb-4 rounded-2xl shadow-lg">
            <h1 class="text-4xl font-black text-gray-900 mb-2">FMEXPRESS</h1>
            <p class="text-gray-600 font-semibold">🇫🇷 Le Pont des Nations 🇧🇯</p>
        </div>

        <!-- FORMULAIRE -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Inscription</h2>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <ul class="text-sm text-red-800 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Prénom</label>
                        <input 
                            type="text" 
                            name="prenom" 
                            value="{{ old('prenom') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="Jean"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nom</label>
                        <input 
                            type="text" 
                            name="nom" 
                            value="{{ old('nom') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                            placeholder="Dupont"
                            required
                        >
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                        placeholder="votre.email@exemple.com"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Téléphone (optionnel)</label>
                    <input 
                        type="tel" 
                        name="telephone" 
                        value="{{ old('telephone') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                        placeholder="+33 6 12 34 56 78"
                    >
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mot de passe</label>
                    <input 
                        type="password" 
                        name="password" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                        placeholder="Minimum 6 caractères"
                        required
                    >
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Confirmer le mot de passe</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                        placeholder="Retapez votre mot de passe"
                        required
                    >
                </div>

                <button 
                    type="submit"
                    class="w-full py-3 bg-gradient-to-r from-blue-600 to-green-600 text-white font-bold rounded-lg hover:shadow-lg transition transform hover:scale-105"
                >
                    S'inscrire
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Déjà un compte ? 
                    <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">
                        Se connecter
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection