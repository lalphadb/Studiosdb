<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PorteOuverteController extends Controller
{
    public function index()
    {
        return view('admin.portes-ouvertes.index');
    }

    public function create()
    {
        return view('admin.portes-ouvertes.create');
    }

    public function store(Request $request)
    {
        // À implémenter
        return redirect()->route('admin.portes-ouvertes.index')
            ->with('success', 'Porte ouverte créée avec succès');
    }

    public function show(string $id)
    {
        return view('admin.portes-ouvertes.show');
    }

    public function edit(string $id)
    {
        return view('admin.portes-ouvertes.edit');
    }

    public function update(Request $request, string $id)
    {
        // À implémenter
        return redirect()->route('admin.portes-ouvertes.index')
            ->with('success', 'Porte ouverte mise à jour avec succès');
    }

    public function destroy(string $id)
    {
        // À implémenter
        return redirect()->route('admin.portes-ouvertes.index')
            ->with('success', 'Porte ouverte supprimée avec succès');
    }

    public function toggleActive($id)
    {
        // À implémenter
        return back()->with('success', 'Statut modifié');
    }

    public function publicForm()
    {
        return view('public.inscription');
    }

    public function submitPublicForm(Request $request)
    {
        // À implémenter
        return redirect()->route('inscription.public')
            ->with('success', 'Inscription enregistrée');
    }
}
