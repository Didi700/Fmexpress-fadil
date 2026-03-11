<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - FMEXPRESS')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100">
    <!-- TOP NAVBAR -->
    <nav class="bg-gradient-to-r from-blue-600 to-green-600 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between h-16">
                <!-- LOGO + MENU -->
                <div class="flex items-center gap-8">
                    <!-- LOGO -->
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 hover:opacity-80 transition">
                        <img src="{{ asset('images/logo.png') }}" alt="FMEXPRESS" class="w-10 h-10 rounded-lg">
                        <span class="font-black text-lg">FMEXPRESS</span>
                    </a>

                    <!-- MENU -->
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'hover:bg-white/10' }} transition font-semibold">
                            🏠 Dashboard
                        </a>
                        <a href="{{ route('admin.envois') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('admin.envois*') ? 'bg-white/20' : 'hover:bg-white/10' }} transition font-semibold">
                            📦 Envois
                        </a>
                        <a href="{{ route('admin.clients') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('admin.clients*') ? 'bg-white/20' : 'hover:bg-white/10' }} transition font-semibold">
                            👥 Clients
                        </a>
                        <a href="{{ route('admin.statistiques') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('admin.statistiques') ? 'bg-white/20' : 'hover:bg-white/10' }} transition font-semibold">
                            📊 Statistiques
                        </a>
                        @if(Auth::user()->role === 'SUPER_ADMIN')
                        <a href="{{ route('admin.admins') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('admin.admins*') ? 'bg-white/20' : 'hover:bg-white/10' }} transition font-semibold">
                            👨‍💼 Admins
                        </a>
                        @endif
                    </div>
                </div>

                <!-- USER + LOGOUT -->
                <div class="flex items-center gap-4">
                    <div class="text-right text-sm">
                        <div class="font-bold">{{ Auth::user()->full_name }}</div>
                        <div class="text-xs opacity-75">⭐ {{ Auth::user()->role }}</div>
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
    <main>
        @yield('content')
    </main>
</body>
</html>