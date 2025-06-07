<?php

namespace App\Http\Controllers;

class LegalController extends Controller
{
    /**
     * Afficher la politique de confidentialité
     */
    public function privacy()
    {
        return view('legal.privacy');
    }

    /**
     * Afficher les conditions d'utilisation
     */
    public function terms()
    {
        return view('legal.terms');
    }

    /**
     * Afficher la page de contact
     */
    public function contact()
    {
        return view('legal.contact');
    }
}
