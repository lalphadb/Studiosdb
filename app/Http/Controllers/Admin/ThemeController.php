<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ThemeController extends Controller
{
    private array $availableThemes = [
        'corporate' => 'Corporate Professional',
        'industrial' => 'Industrial Dark', 
        'minimalist' => 'Minimalist Green',
        'navy' => 'Navy Professional',
        'quantum-dark' => 'Quantum Dark',
        'nebula-obsidian' => 'Nebula Obsidian',
        'matrix-crimson' => 'Matrix Crimson'
    ];

    public function index()
    {
        return view('admin.themes.index', [
            'themes' => $this->availableThemes,
            'currentTheme' => session('selected_theme', 'corporate')
        ]);
    }

    public function switch(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'required|string|in:' . implode(',', array_keys($this->availableThemes))
        ]);
        
        try {
            session(['selected_theme' => $validated['theme']]);
            
            Log::info('Thème changé', [
                'theme' => $validated['theme'],
                'user_id' => auth()->id()
            ]);
            
            return back()->with('success', 'Thème changé vers : ' . $this->availableThemes[$validated['theme']]);
            
        } catch (\Exception $e) {
            Log::error('Erreur changement thème: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Erreur lors du changement de thème.']);
        }
    }
}