<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HorairesController extends Controller
{
    public function selection()
    {
        // Pour l'instant, retourner au dashboard
        return redirect()->route('admin.dashboard')
            ->with('info', 'La sélection des horaires sera bientôt disponible.');
    }

    public function saveSelection(Request $request)
    {
        // À implémenter
        return redirect()->route('admin.dashboard');
    }
}
