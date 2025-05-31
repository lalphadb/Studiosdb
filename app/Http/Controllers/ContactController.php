<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }
    
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|in:general,inscription,horaire,tarifs,donnees,technique,plainte,autre',
            'message' => 'required|string|max:2000',
            'consent' => 'required|accepted'
        ]);
        
        // Ici vous pouvez ajouter la logique pour envoyer l'email
        // Mail::to('info@studiosunis.com')->send(new ContactMessage($validated));
        
        return redirect()->route('contact')->with('success', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les 24-48 heures.');
    }
}
