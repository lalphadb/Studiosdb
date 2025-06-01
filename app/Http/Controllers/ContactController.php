<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'sujet' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // Envoyer l'email ou enregistrer dans la BD
        // Pour l'instant, juste rediriger avec un message de succès

        return back()->with('success', 'Votre message a été envoyé avec succès.');
    }
}
