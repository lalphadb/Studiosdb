<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMembreRequest;
use App\Http\Requests\UpdateMembreRequest;
use App\Models\Ecole;
use App\Models\Membre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MembresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Optionnel: $this->middleware('can:viewAny,Membre')->only('index');
    }

    public function index(Request $request)
    {
        try {
            $query = Membre::with(['ecole']);

            if (Auth::user()->role !== 'superadmin' && Auth::user()->ecole_id) {
                $query->where('ecole_id', Auth::user()->ecole_id);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
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
            $ecoles = Ecole::where('statut', 'active')->orderBy('nom')->paginate(20);

            $stats = [
                'total' => Membre::count(),
                'approuves' => Membre::where('approuve', true)->count(),
                'en_attente' => Membre::where('approuve', false)->count(),
                'ce_mois' => Membre::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
            ];

            return view('admin.membres.index', compact('membres', 'ecoles', 'stats'));

        } catch (\Exception $e) {
            Log::error('Erreur MembresController@index: '.$e->getMessage());

            $membres = collect();
            $ecoles = collect();
            $stats = ['total' => 0, 'approuves' => 0, 'en_attente' => 0, 'ce_mois' => 0];

            return view('admin.membres.index', compact('membres', 'ecoles', 'stats'))
                ->with('error', 'Une erreur est survenue lors du chargement.');
        }
    }

    public function create()
    {
        $this->authorize('create', Membre::class);

        $ecoles = Ecole::where('statut', 'active')->orderBy('nom')->paginate(20);

        return view('admin.membres.create', compact('ecoles'));
    }

    public function store(StoreMembreRequest $request)
    {
        $this->authorize('create', Membre::class);

        try {
            $membre = Membre::create($request->validated());

            activity()
                ->causedBy(Auth::user())
                ->performedOn($membre)
                ->withProperties(['attributes' => $request->validated()])
                ->log('Création membre');

            return redirect()->route('admin.membres.index')
                ->with('success', 'Membre créé avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur création membre: '.$e->getMessage());

            return redirect()->back()->withInput()
                ->with('error', 'Erreur lors de la création du membre.');
        }
    }

    public function show(Membre $membre)
    {
        $this->authorize('view', $membre);

        $membre->load('ecole');

        return view('admin.membres.show', compact('membre'));
    }

    public function edit(Membre $membre)
    {
        $this->authorize('update', $membre);

        $ecoles = Ecole::where('statut', 'active')->orderBy('nom')->paginate(20);

        return view('admin.membres.edit', compact('membre', 'ecoles'));
    }

    public function update(UpdateMembreRequest $request, Membre $membre)
    {
        $this->authorize('update', $membre);

        try {
            $membre->update($request->validated());

            activity()
                ->causedBy(Auth::user())
                ->performedOn($membre)
                ->withProperties(['attributes' => $request->validated()])
                ->log('Mise à jour membre');

            return redirect()->route('admin.membres.index')
                ->with('success', 'Membre mis à jour avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur mise à jour membre: '.$e->getMessage());

            return redirect()->back()->withInput()
                ->with('error', 'Erreur lors de la mise à jour.');
        }
    }

    public function destroy(Membre $membre)
    {
        $this->authorize('delete', $membre);

        try {
            // Anonymisation pour Loi 25/RGPD
            $membre->anonymize();

            activity()
                ->causedBy(Auth::user())
                ->performedOn($membre)
                ->log('Suppression/anonymisation membre');

            return redirect()->route('admin.membres.index')
                ->with('success', 'Membre supprimé (anonymisé) avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur suppression membre: '.$e->getMessage());

            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression.');
        }
    }

    public function approve(Membre $membre)
    {
        $this->authorize('update', $membre);

        try {
            $membre->update(['approuve' => ! $membre->approuve]);
            $status = $membre->approuve ? 'approuvé' : 'mis en attente';

            activity()
                ->causedBy(Auth::user())
                ->performedOn($membre)
                ->withProperties(['approuve' => $membre->approuve])
                ->log('Changement statut approbation membre');

            return redirect()->back()
                ->with('success', "Membre {$status} avec succès.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de l\'approbation.');
        }
    }
}
