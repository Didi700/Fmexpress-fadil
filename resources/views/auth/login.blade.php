@extends('layouts.app')

@section('title', 'Connexion - FMEXPRESS')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-green-50 px-4">
    <div class="max-w-md w-full">
        <!-- LOGO -->
        <div class="text-center mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="FMEXPRESS" class="w-24 h-24 mx-auto mb-4 rounded-2xl shadow-lg">
            <h1 class="text-4xl font-black text-gray-900 mb-2">FMEXPRESS</h1>
            <p class="text-gray-600 font-semibold">🇫🇷 Le Pont des Nations 🇧🇯</p>
        </div>

        <!-- FORMULAIRE -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Connexion</h2>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-sm text-red-800">{{ $errors->first() }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

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
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mot de passe</label>
                    <input 
                        type="password" 
                        name="password" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                        placeholder="••••••••"
                        required
                    >
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
                    </label>
                </div>

                <button 
                    type="submit"
                    class="w-full py-3 bg-gradient-to-r from-blue-600 to-green-600 text-white font-bold rounded-lg hover:shadow-lg transition transform hover:scale-105"
                >
                    Se connecter
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Pas encore de compte ? 
                    <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">
                        S'inscrire
                    </a>
                </p>
            </div>
        </div>

        <!-- COMPTES DE TEST -->
        <div class="mt-6 p-4 bg-white rounded-lg border border-gray-200 shadow">
            <p class="text-xs font-semibold text-gray-700 mb-2">🔑 Comptes de test :</p>
            <div class="text-xs text-gray-600 space-y-1">
                <p><strong>Super Admin:</strong> fadilassane700@gmail.com / password</p>
                <p><strong>Client:</strong> marie@example.com / password</p>
            </div>
        </div>
    </div>
</div>
@endsection