<aside class="fixed left-0 top-0 h-full w-64 bg-gradient-to-b from-indigo-600 to-purple-700 text-white shadow-2xl z-50">
    <div class="p-6 border-b border-white/20">
        <div class="flex items-center gap-3 mb-4">
            <!-- LOGO -->
            <img src="{{ asset('images/logo.png') }}" alt="FMEXPRESS Logo" class="w-12 h-12 rounded-lg object-cover">
            
            <div>
                <div class="font-black text-lg">FMEXPRESS</div>
                <div class="text-xs text-yellow-300">🇫🇷 France ⟷ Bénin 🇧🇯</div>
            </div>
        </div>

        <div class="bg-white/10 rounded-lg p-3 border border-white/20">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-yellow-400 rounded-lg flex items-center justify-center text-gray-900 font-black text-lg">
                    {{ substr(Auth::user()->prenom, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-bold text-sm truncate">{{ Auth::user()->prenom }}</div>
                    <div class="text-xs text-yellow-300">⭐ {{ Auth::user()->role }}</div>
                </div>
            </div>
        </div>
    </div>

    <nav class="p-4 space-y-1">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'hover:bg-white/10' }} rounded-lg font-semibold text-sm transition">
            <span class="text-lg">📊</span>
            <span>Dashboard</span>
        </a>
        @if(Auth::user()->isSuperAdmin())
        <a href="{{ route('admin.admins') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('admin.admins*') ? 'bg-white/20' : 'hover:bg-white/10' }} rounded-lg font-semibold text-sm transition">
            <span class="text-lg">👥</span>
            <span>Administrateurs</span>
        </a>
        @endif
        <a href="{{ route('admin.envois') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('admin.envois*') ? 'bg-white/20' : 'hover:bg-white/10' }} rounded-lg font-semibold text-sm transition">
            <span class="text-lg">📦</span>
            <span>Envois</span>
        </a>
        <a href="{{ route('admin.clients') }}" class="flex items-center gap-3 px-4 py-2.5 {{ request()->routeIs('admin.clients*') ? 'bg-white/20' : 'hover:bg-white/10' }} rounded-lg font-semibold text-sm transition">
            <span class="text-lg">👤</span>
            <span>Clients</span>
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-2.5 hover:bg-white/10 rounded-lg font-semibold text-sm transition">
            <span class="text-lg">💰</span>
            <span>Paiements</span>
        </a>
        <a href="#" class="flex items-center gap-3 px-4 py-2.5 hover:bg-white/10 rounded-lg font-semibold text-sm transition">
            <span class="text-lg">⚙️</span>
            <span>Paramètres</span>
        </a>
        <!-- STATISTIQUES -->
        <a href="{{ route('admin.statistiques') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.statistiques') ? 'bg-white/20 text-white' : 'text-white/70 hover:bg-white/10' }} transition">
            <span class="text-xl">📊</span>
            <span class="font-bold">Statistiques</span>
        </a>
    </nav>

    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-white/20">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full py-2.5 bg-red-500 hover:bg-red-600 rounded-lg text-sm font-bold transition">
                🚪 Déconnexion
            </button>
        </form>
    </div>
</aside>s