<?php

// app/Http/Controllers/Admin/CeintureController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ceinture;
use App\Models\Membre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CeintureController extends Controller
{
    public function index()
    {
        $ceintures = Ceinture::orderBy('ordre')->paginate(20);

        return view('admin.ceintures.index', compact('ceintures'));
    }

    public function create()
    {
        return view('admin.ceintures.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'couleur' => 'required|string|max:50',
            'ordre' => 'required|integer|min:0',
            'niveau' => 'required|integer|min:0',
        ]);

        Ceinture::create($validated);

        return redirect()->route('admin.ceintures.index')
            ->with('success', 'Ceinture créée avec succès');
    }

    public function show(Ceinture $ceinture)
    {
        $membres = $ceinture->membres()->paginate(20);

        return view('admin.ceintures.show', compact('ceinture', 'membres'));
    }

    public function edit(Ceinture $ceinture)
    {
        return view('admin.ceintures.edit', compact('ceinture'));
    }

    public function update(Request $request, Ceinture $ceinture)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'couleur' => 'required|string|max:50',
            'ordre' => 'required|integer|min:0',
            'niveau' => 'required|integer|min:0',
        ]);

        $ceinture->update($validated);

        return redirect()->route('admin.ceintures.index')
            ->with('success', 'Ceinture mise à jour avec succès');
    }

    public function destroy(Ceinture $ceinture)
    {
        $ceinture->delete();

        return redirect()->route('admin.ceintures.index')
            ->with('success', 'Ceinture supprimée avec succès');
    }

    /**
     * Assigner une ceinture à un membre
     */
    public function assignToMember(Request $request)
    {
        $validated = $request->validate([
            'membre_id' => 'required|exists:membres,id',
            'ceinture_id' => 'required|exists:ceintures,id',
            'date_obtention' => 'required|date',
        ]);

        DB::table('ceintures_membres')->insert([
            'membre_id' => $validated['membre_id'],
            'ceinture_id' => $validated['ceinture_id'],
            'date_obtention' => $validated['date_obtention'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Ceinture assignée avec succès');
    }

    /**
     * Voir la progression d'un membre
     */
    public function progression(Membre $membre)
    {
        $progression = $membre->ceintures()
            ->orderBy('date_obtention')
            ->get();

        return view('admin.ceintures.progression', compact('membre', 'progression'));
    }
}
