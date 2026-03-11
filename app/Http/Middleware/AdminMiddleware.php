<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Vérifier si l'utilisateur est admin ou super admin
        $user = Auth::user();
        if ($user->role !== 'ADMIN' && $user->role !== 'SUPER_ADMIN') {
            abort(403, 'Accès refusé - Réservé aux administrateurs');
        }

        return $next($request);
    }
}