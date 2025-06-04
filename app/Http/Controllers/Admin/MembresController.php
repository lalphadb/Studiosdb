<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membre;
use App\Models\Ecole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MembresController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Membre::with(['ecole']);
            
            if (Auth::user()->role !== 'superadmin' && Auth::user()->ecole_id) {
                $query->where('ecole_id', Auth::user()->ecole_id);
            }
            
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nom', 'like', "%{$search}%")
                      ->orWhere('prenom', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }
            
            if ($request->filled('ecole_id')) {
                $query->where('ecole_id', $request->ecole_id);
            }
            
            if ($request->filled('statut')) {
                if ($request->statut === 'approuve') {
                    $query->where('approuve', true);
                } elseif ($request->statut === 'en_attente') {
                    $query->where('approuve', false);
                }
            }
            
            $membres = $query->orderBy('created_at', 'desc')->paginate(15);
            $ecoles = Ecole::where('active', true)->orderBy('nom')->paginate(20);
            
            $stats = [
                'total' => Membre::count(),
                'approuves' => Membre::where('approuve', true)->count(),
                'en_attente' => Membre::where('approuve', false)->count(),
                'ce_mois' => Membre::whereMonth('created_at', now()->month)
                                  ->whereYear('created_at', now()->year)
                                  ->count()
            ];
            
            return view('admin.membres.index', compact('membres', 'ecoles', 'stats'));
            
        } catch (\Exception $e) {
            Log::error('Erreur MembresController@index: ' . $e->getMessage());
            
            $membres = collect();
            $ecoles = collect();
            $stats = ['total' => 0, 'approuves' => 0, 'en_attente' => 0, 'ce_mois' => 0];
            
            return view('admin.membres.index', compact('membres', 'ecoles', 'stats'))
                   ->with('error', 'Une erreur est survenue lors du chargement.');
        }
    }

    public function create()
    {
        $ecoles = Ecole::where('active', true)->orderBy('nom')->paginate(20);
        return view('admin.membres.create', compact('ecoles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|unique:membres,email',
            'ecole_id' => 'required|exists:ecoles,id',
        ]);

        try {
            Membre::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'date_naissance' => $request->date_naissance,
                'sexe' => $request->sexe,
                'ecole_id' => $request->ecole_id,
                'numero_rue' => $request->numero_rue,
                'nom_rue' => $request->nom_rue,
                'ville' => $request->ville,
                'province' => $request->province ?? 'QC',
                'code_postal' => $request->code_postal,
                'approuve' => $request->has('approuve')
            ]);

            return redirect()->route('admin.membres.index')
                           ->with('success', 'Membre créé avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur création membre: ' . $e->getMessage());
            return redirect()->back()->withInput()
                           ->with('error', 'Erreur lors de la création du membre.');
        }
    }

    public function show(Membre $membre)
    {
        $membre->load('ecole');
        return view('admin.membres.show', compact('membre'));
    }

    public function edit(Membre $membre)
    {
        $ecoles = Ecole::where('active', true)->orderBy('nom')->paginate(20);
        return view('admin.membres.edit', compact('membre', 'ecoles'));
    }

    public function update(Request $request, Membre $membre)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'nullable|email|unique:membres,email,' . $membre->id,
            'ecole_id' => 'required|exists:ecoles,id',
        ]);

        try {
            $membre->update([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'date_naissance' => $request->date_naissance,
                'sexe' => $request->sexe,
                'ecole_id' => $request->ecole_id,
                'numero_rue' => $request->numero_rue,
                'nom_rue' => $request->nom_rue,
                'ville' => $request->ville,
                'province' => $request->province,
                'code_postal' => $request->code_postal,
                'approuve' => $request->has('approuve')
            ]);

            return redirect()->route('admin.membres.index')
                           ->with('success', 'Membre mis à jour avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur mise à jour membre: ' . $e->getMessage());
            return redirect()->back()->withInput()
                           ->with('error', 'Erreur lors de la mise à jour.');
        }
    }

    public function destroy(Membre $membre)
    {
        try {
            $membre->delete();
            return redirect()->route('admin.membres.index')
                           ->with('success', 'Membre supprimé avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur suppression membre: ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Erreur lors de la suppression.');
        }
    }

    public function approve(Membre $membre)
    {
        try {
            $membre->update(['approuve' => !$membre->approuve]);
            $status = $membre->approuve ? 'approuvé' : 'mis en attente';
            
            return redirect()->back()
                           ->with('success', "Membre {$status} avec succès.");
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Erreur lors de l\'approbation.');
        }
    }
}
