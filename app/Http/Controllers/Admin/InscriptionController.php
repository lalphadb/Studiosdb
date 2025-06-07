<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\Ecole;
use App\Models\Inscription;
use App\Models\Membre;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InscriptionCoursController extends Controller
{
    public function index(Request $request)
    {
        $query = Inscription::with(['membre', 'cours.ecole', 'cours.session']);

        // Filtres
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('membre', function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('cours', function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%");
            });
        }

        if ($request->filled('cours_id')) {
            $query->where('cours_id', $request->cours_id);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('ecole_id')) {
            $query->whereHas('cours', function ($q) use ($request) {
                $q->where('ecole_id', $request->ecole_id);
            });
        }

        $inscriptions = $query->latest()->paginate(20);

        // Statistiques
        $stats = [
            'total' => Inscription::count(),
            'confirmees' => Inscription::where('statut', 'confirmee')->count(),
            'attente' => Inscription::where('statut', 'liste_attente')->count(),
            'cette_semaine' => Inscription::where('created_at', '>=', Carbon::now()->startOfWeek())->count(),
        ];

        // Données pour les filtres
        $cours = Cours::with('ecole')->where('actif', true)->get();
        $ecoles = Ecole::where('active', true)->get();

        return view('admin.inscriptions.index', compact('inscriptions', 'stats', 'cours', 'ecoles'));
    }

    public function create()
    {
        $membres = Membre::where('approuve', true)->orderBy('nom')->get();
        $cours = Cours::with(['ecole', 'session'])
            ->where('actif', true)
            ->whereRaw('(places_max IS NULL OR (SELECT COUNT(*) FROM inscriptions WHERE cours_id = cours.id AND statut = "confirmee") < places_max)')
            ->get();

        return view('admin.inscriptions.create', compact('membres', 'cours'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'membre_id' => 'required|exists:membres,id',
            'cours_id' => 'required|exists:cours,id',
            'notes' => 'nullable|string|max:500',
        ]);

        $cours = Cours::findOrFail($request->cours_id);

        // Vérifier si le membre est déjà inscrit
        $existingInscription = Inscription::where('membre_id', $request->membre_id)
            ->where('cours_id', $request->cours_id)
            ->whereIn('statut', ['confirmee', 'liste_attente'])
            ->first();

        if ($existingInscription) {
            return redirect()->back()->with('error', 'Ce membre est déjà inscrit à ce cours.');
        }

        // Vérifier les places disponibles
        $inscriptionsConfirmees = Inscription::where('cours_id', $cours->id)
            ->where('statut', 'confirmee')
            ->count();

        $statut = 'confirmee';
        if ($cours->places_max && $inscriptionsConfirmees >= $cours->places_max) {
            $statut = 'liste_attente';
        }

        // Créer l'inscription
        $inscription = Inscription::create([
            'membre_id' => $request->membre_id,
            'cours_id' => $request->cours_id,
            'statut' => $statut,
            'date_inscription' => now(),
            'notes' => $request->notes,
        ]);

        // TODO: Envoyer email de confirmation

        $message = $statut === 'confirmee'
            ? 'Inscription confirmée avec succès!'
            : 'Inscription ajoutée à la liste d\'attente.';

        return redirect()->route('admin.inscriptions.index')->with('success', $message);
    }

    public function updateStatut(Inscription $inscription, Request $request)
    {
        $validated = $request->validate([
            'statut' => 'required|in:confirmee,liste_attente,annulee',
        ]);

        $ancienStatut = $inscription->statut;
        $inscription->update(['statut' => $validated['statut']]);

        // Si on confirme une inscription en liste d'attente
        if ($ancienStatut === 'liste_attente' && $validated['statut'] === 'confirmee') {
            // TODO: Envoyer email de confirmation
        }

        return redirect()->back()->with('success', 'Statut mis à jour avec succès!');
    }

    public function destroy(Inscription $inscription)
    {
        $inscription->delete();

        // Promouvoir automatiquement le premier en liste d'attente
        if ($inscription->statut === 'confirmee' && $inscription->cours->places_max) {
            $nextInLine = Inscription::where('cours_id', $inscription->cours_id)
                ->where('statut', 'liste_attente')
                ->orderBy('created_at')
                ->first();

            if ($nextInLine) {
                $nextInLine->update(['statut' => 'confirmee']);
                // TODO: Envoyer email de notification
            }
        }

        return redirect()->back()->with('success', 'Inscription supprimée avec succès!');
    }

    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'inscriptions' => 'required|array',
            'action' => 'required|in:confirm,cancel,delete',
        ]);

        $inscriptions = Inscription::whereIn('id', $validated['inscriptions'])->get();

        switch ($validated['action']) {
            case 'confirm':
                foreach ($inscriptions as $inscription) {
                    if ($inscription->statut === 'liste_attente') {
                        $inscription->update(['statut' => 'confirmee']);
                    }
                }
                $message = 'Inscriptions confirmées avec succès!';
                break;

            case 'cancel':
                foreach ($inscriptions as $inscription) {
                    $inscription->update(['statut' => 'annulee']);
                }
                $message = 'Inscriptions annulées avec succès!';
                break;

            case 'delete':
                foreach ($inscriptions as $inscription) {
                    $inscription->delete();
                }
                $message = 'Inscriptions supprimées avec succès!';
                break;
        }

        return redirect()->back()->with('success', $message);
    }
}
