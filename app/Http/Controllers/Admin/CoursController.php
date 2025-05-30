<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use Illuminate\Http\Request;

class CoursController extends Controller
{
    public function index()
    {
        $cours = Cours::with(['ecole', 'session'])->latest()->paginate(15);
        return view('admin.cours.index', compact('cours'));
    }
    
    public function show(Cours $cours)
    {
        $cours->load(['ecole', 'session', 'horaires', 'inscriptions']);
        return view('admin.cours.show', compact('cours'));
    }
    
    public function create()
    {
        return view('admin.cours.create');
    }
    
    public function store(Request $request)
    {
        // Logique à implémenter
        return redirect()->route('admin.cours.index');
    }
    
    public function edit(Cours $cours)
    {
        return view('admin.cours.edit', compact('cours'));
    }
    
    public function update(Request $request, Cours $cours)
    {
        // Logique à implémenter
        return redirect()->route('admin.cours.show', $cours);
    }
    
    public function destroy(Cours $cours)
    {
        $cours->delete();
        return redirect()->route('admin.cours.index');
    }
}
