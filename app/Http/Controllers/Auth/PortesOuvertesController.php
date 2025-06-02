<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PorteOuverte;
use App\Models\InscriptionPorteOuverte;
use Illuminate\Http\Request;

class PortesOuvertesController extends Controller
{
    public function getDates($ecoleId)
    {
        $dates = PorteOuverte::where('ecole_id', $ecoleId)
            ->where('active', true)
            ->where('date', '>=', now())
            ->get();

        return response()->json($dates);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'po_date_id' => 'required|exists:portes_ouvertes,id',
            'po_prenom' => 'required|string|max:255',
            'po_nom' => 'required|string|max:255',
            'po_email' => 'required|email',
            'po_telephone' => 'nullable|string|max:20',
        ]);

        InscriptionPorteOuverte::create([
            'porte_ouverte_id' => $validated['po_date_id'],
            'prenom' => $validated['po_prenom'],
            'nom' => $validated['po_nom'],
            'email' => $validated['po_email'],
            'telephone' => $validated['po_telephone'],
        ]);

        return redirect()->route('login')->with('success', 'Inscription confirmée! Vous recevrez un email de confirmation.');
    }
}
