<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Envoi;

class TrackingController extends Controller
{
    public function recherche(Request $request)
    {
        $validated = $request->validate([
            'numero_suivi' => 'required|string|size:15',
        ]);

        // Rechercher l'envoi par numéro de suivi
        $envoi = Envoi::with(['user', 'lignes', 'logs.admin'])
            ->where('numero_suivi', $validated['numero_suivi'])
            ->first();

        if (!$envoi) {
            return back()->withErrors(['numero_suivi' => 'Aucun envoi trouvé avec ce numéro de suivi.'])->withInput();
        }

        return view('public.tracking-result', compact('envoi'));
    }
}