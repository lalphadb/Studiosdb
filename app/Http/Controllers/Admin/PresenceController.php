<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presence;
use App\Models\Cours;
use App\Models\Membre;
use Illuminate\Http\Request;

class PresenceController extends Controller
{
    public function index()
    {
        $presences = Presence::with(['membre', 'cours'])
                            ->latest('date_presence')
                            ->paginate(20);

        return view('admin.presences.index', compact('presences'));
    }

    public function create()
    {
        $cours = Cours::where('statut', 'actif')->with('ecole')->get();
        $membres = Membre::where('approuve', true)->with('ecole')->get();

        return view('admin.presences.create', compact('cours', 'membres'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'membre_id' => 'required|exists:membres,id',
            'cours_id' => 'required|exists:cours,id',
            'date_presence' => 'required|date',
            'status' => 'required|in:present,absent,retard',
            'commentaire' => 'nullable|string',
        ]);

        Presence::create($data);

        return redirect()->route('admin.presences.index')
                        ->with('success', 'Présence enregistrée avec succès.');
    }
}
