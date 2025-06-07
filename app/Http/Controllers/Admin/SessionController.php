<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoursSession;
use App\Models\Ecole;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SessionController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        try {
            $validated = $request->validate([
                'ecole_id' => 'nullable|exists:ecoles,id',
                'search' => 'nullable|string|max:255',
                'active' => 'nullable|in:0,1',
            ]);

            $user = Auth::user();
            $query = CoursSession::with(['ecole']);

            // Filtrage par rôle sécurisé
            if ($user->role !== 'superadmin' && $user->ecole_id) {
                $query->where('ecole_id', $user->ecole_id);
            }

            // Application des filtres
            if (! empty($validated['ecole_id'])) {
                if ($user->role !== 'superadmin' && $validated['ecole_id'] != $user->ecole_id) {
                    abort(403, 'Accès non autorisé à cette école.');
                }
                $query->where('ecole_id', $validated['ecole_id']);
            }

            if (! empty($validated['search'])) {
                $search = strip_tags($validated['search']);
                $query->where(function ($q) use ($search) {
                    $q->where('nom', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            }

            if (isset($validated['active'])) {
                $query->where('active', (bool) $validated['active']);
            }

            $sessions = $query->orderBy('date_debut', 'desc')->paginate(15);

            // Données pour les filtres
            $ecoles = $user->role === 'superadmin'
                ? Ecole::where('active', true)->orderBy('nom')->get()
                : collect();

            return view('admin.sessions.index', compact('sessions', 'ecoles'));

        } catch (\Exception $e) {
            Log::error('Erreur SessionController@index: '.$e->getMessage());

            return view('admin.sessions.index', [
                'sessions' => collect(),
                'ecoles' => collect(),
            ])->withErrors(['error' => 'Erreur lors du chargement des sessions.']);
        }
    }

    public function create()
    {
        $this->authorize('create', CoursSession::class);

        $ecoles = Auth::user()->role === 'superadmin'
            ? Ecole::where('active', true)->orderBy('nom')->get()
            : Ecole::where('id', Auth::user()->ecole_id)->where('active', true)->get();

        return view('admin.sessions.create', compact('ecoles'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', CoursSession::class);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'ecole_id' => 'required|exists:ecoles,id',
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after:date_debut',
            'date_limite_inscription' => 'nullable|date|before_or_equal:date_debut',
            'couleur' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'visible' => 'boolean',
            'inscriptions_actives' => 'boolean',
        ]);

        // Vérification des permissions d'école
        if (Auth::user()->role !== 'superadmin' && $validated['ecole_id'] != Auth::user()->ecole_id) {
            abort(403, 'Accès non autorisé à cette école.');
        }

        try {
            $session = CoursSession::create($validated);

            Log::info('Session créée', ['session_id' => $session->id, 'user_id' => Auth::id()]);

            return redirect()->route('admin.sessions.index')
                ->with('success', 'Session créée avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur création session: '.$e->getMessage());

            return back()->withInput()->withErrors(['error' => 'Erreur lors de la création de la session.']);
        }
    }

    public function show(CoursSession $session)
    {
        $this->authorize('view', $session);

        $session->load(['ecole', 'cours']);

        return view('admin.sessions.show', compact('session'));
    }

    public function edit(CoursSession $session)
    {
        $this->authorize('update', $session);

        $ecoles = Auth::user()->role === 'superadmin'
            ? Ecole::where('active', true)->orderBy('nom')->get()
            : Ecole::where('id', Auth::user()->ecole_id)->where('active', true)->get();

        return view('admin.sessions.edit', compact('session', 'ecoles'));
    }

    public function update(Request $request, CoursSession $session)
    {
        $this->authorize('update', $session);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'ecole_id' => 'required|exists:ecoles,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'date_limite_inscription' => 'nullable|date|before_or_equal:date_debut',
            'couleur' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'visible' => 'boolean',
            'inscriptions_actives' => 'boolean',
        ]);

        // Vérification des permissions d'école
        if (Auth::user()->role !== 'superadmin' && $validated['ecole_id'] != Auth::user()->ecole_id) {
            abort(403, 'Accès non autorisé à cette école.');
        }

        try {
            $session->update($validated);

            Log::info('Session mise à jour', ['session_id' => $session->id, 'user_id' => Auth::id()]);

            return redirect()->route('admin.sessions.index')
                ->with('success', 'Session mise à jour avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur mise à jour session: '.$e->getMessage());

            return back()->withInput()->withErrors(['error' => 'Erreur lors de la mise à jour.']);
        }
    }

    public function destroy(CoursSession $session)
    {
        $this->authorize('delete', $session);

        try {
            $session->delete();

            Log::info('Session supprimée', ['session_id' => $session->id, 'user_id' => Auth::id()]);

            return redirect()->route('admin.sessions.index')
                ->with('success', 'Session supprimée avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur suppression session: '.$e->getMessage());

            return back()->withErrors(['error' => 'Erreur lors de la suppression.']);
        }
    }
}
