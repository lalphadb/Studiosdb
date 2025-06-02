<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Membre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.login'); // Utilise la même vue avec les tabs
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'member_type' => 'required|in:new,existing',
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'ecole_id' => 'required|exists:ecoles,id',
        ]);

        // Logger l'inscription (Loi 25)
        Log::channel('auth')->info('Nouvelle inscription', [
            'email' => $validated['email'],
            'type' => $validated['member_type'],
            'ecole_id' => $validated['ecole_id'],
            'ip' => $request->ip(),
        ]);

        // Créer l'utilisateur
        $user = User::create([
            'name' => $validated['prenom'] . ' ' . $validated['nom'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'ecole_id' => $validated['ecole_id'],
        ]);

        // Créer le membre
        $membre = Membre::create([
            'prenom' => $validated['prenom'],
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'ecole_id' => $validated['ecole_id'],
            'user_id' => $user->id,
            'approuve' => $validated['member_type'] === 'existing',
        ]);

        if ($validated['member_type'] === 'existing') {
            auth()->login($user);
            return redirect()->route('horaires.selection');
        }

        return redirect()->route('login')->with('success', 'Inscription réussie! Un administrateur va valider votre compte.');
    }
}
