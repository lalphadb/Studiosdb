<?php

namespace App\Http\Controllers;

use App\Models\DemandeInscription;
use Illuminate\Http\Request;

class PortesOuvertesPublicController extends Controller
{
    public function showForm()
    {
        return view('public.portes-ouvertes.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email',
            'telephone' => 'required|string',
            'ecole_id' => 'required|exists:ecoles,id',
        ]);

        DemandeInscription::create($validated);

        return redirect()->route('portes-ouvertes.register')
            ->with('success', 'Votre demande a été enregistrée avec succès!');
    }
}
