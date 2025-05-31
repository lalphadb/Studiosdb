<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InscriptionCours;
use App\Models\Cours;
use App\Models\Membre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InscriptionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = InscriptionCours::with(['membre', 'cours.ecole']);
        
        if ($user->role !== 'superadmin' && $user->ecole_id) {
            $query->whereHas('cours', function($q) use ($user) {
                $q->where('ecole_id', $user->ecole_id);
            });
        }
        
        $inscriptions = $query->latest()->paginate(20);
        
        return view('admin.inscriptions.index', compact('inscriptions'));
    }
    
    public function create()
    {
        $user = Auth::user();
        
        $coursQuery = Cours::where('actif', true);
        if ($user->role !== 'superadmin' && $user->ecole_id) {
            $coursQuery->where('ecole_id', $user->ecole_id);
        }
        $cours = $coursQuery->orderBy('nom')->get();
        
        $membresQuery = Membre::where('approuve', true);
        if ($user->role !== 'superadmin' && $user->ecole_id) {
            $membresQuery->where('ecole_id', $user->ecole_id);
        }
        $membres = $membresQuery->orderBy('nom')->orderBy('prenom')->get();
        
        return view('admin.inscriptions.create', compact('cours', 'membres'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'membre_id' => 'required|exists:membres,id',
            'cours_id' => 'required|exists:cours,id',
            'date_inscription' => 'nullable|date',
            'statut' => 'required|in:en_attente,confirmee,annulee'
        ]);
        
        // Vérifier que le membre n'est pas déjà inscrit à ce cours
        $exists = InscriptionCours::where('membre_id', $validated['membre_id'])
            ->where('cours_id', $validated['cours_id'])
            ->where('statut', '!=', 'annulee')
            ->exists();
            
        if ($exists) {
            return back()->withErrors(['error' => 'Ce membre est déjà inscrit à ce cours.']);
        }
        
        $validated['date_inscription'] = $validated['date_inscription'] ?? now();
        
        InscriptionCours::create($validated);
        
        Log::info('Inscription créée', [
            'membre_id' => $validated['membre_id'], 
            'cours_id' => $validated['cours_id'],
            'user_id' => Auth::id()
        ]);
        
        return redirect()->route('admin.inscriptions.index')
            ->with('success', 'Inscription créée avec succès.');
    }
    
    public function destroy(InscriptionCours $inscription)
    {
        $user = Auth::user();
        
        // Vérifier les permissions
        if ($user->role !== 'superadmin' && $user->ecole_id != $inscription->cours->ecole_id) {
            abort(403, 'Accès non autorisé');
        }
        
        $inscription->delete();
        
        Log::info('Inscription supprimée', [
            'inscription_id' => $inscription->id,
            'user_id' => Auth::id()
        ]);
        
        return redirect()->back()
            ->with('success', 'Inscription supprimée avec succès.');
    }
}
