<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ecole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Liste des utilisateurs selon le rôle connecté
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // SuperAdmin voit tous les utilisateurs
        if ($user->hasRole('superadmin')) {
            $users = User::with(['ecole', 'roles'])
                ->when($request->search, function($query, $search) {
                    $query->where(function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%")
                          ->orWhere('username', 'like', "%{$search}%");
                    });
                })
                ->when($request->ecole_id, function($query, $ecole) {
                    $query->where('ecole_id', $ecole);
                })
                ->when($request->role, function($query, $role) {
                    $query->role($role);
                })
                ->orderBy('name')
                ->paginate(20);
                
            $ecoles = Ecole::orderBy('nom')->get();
            $roles = Role::all();
            
        } else if ($user->hasRole('admin')) {
            // Admin d'école voit seulement les utilisateurs de son école
            $users = User::with(['ecole', 'roles'])
                ->where('ecole_id', $user->ecole_id)
                ->when($request->search, function($query, $search) {
                    $query->where(function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%")
                          ->orWhere('username', 'like', "%{$search}%");
                    });
                })
                ->when($request->role, function($query, $role) {
                    $query->role($role);
                })
                ->orderBy('name')
                ->paginate(20);
                
            $ecoles = collect([$user->ecole]); // Seulement son école
            $roles = Role::whereIn('name', ['user', 'instructeur'])->get(); // Rôles limités
            
        } else {
            abort(403, 'Accès non autorisé');
        }

        return view('admin.users.index', compact('users', 'ecoles', 'roles'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        $user = Auth::user();
        
        if ($user->hasRole('superadmin')) {
            $ecoles = Ecole::orderBy('nom')->get();
            $roles = Role::all();
        } else if ($user->hasRole('admin')) {
            $ecoles = collect([$user->ecole]);
            $roles = Role::whereIn('name', ['user', 'instructeur'])->get();
        } else {
            abort(403);
        }

        return view('admin.users.create', compact('ecoles', 'roles'));
    }

    /**
     * Création d'utilisateur
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:50|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'ecole_id' => 'required|exists:ecoles,id',
            'role' => 'required|exists:roles,name',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:50',
            'code_postal' => 'nullable|string|max:10',
            'date_naissance' => 'nullable|date',
            'sexe' => 'nullable|in:M,F,Autre'
        ];

        // Admin d'école ne peut créer que pour son école
        if ($user->hasRole('admin')) {
            $rules['ecole_id'] = [
                'required',
                Rule::in([$user->ecole_id])
            ];
            $rules['role'] = [
                'required',
                Rule::in(['user', 'instructeur'])
            ];
        }

        $validated = $request->validate($rules);

        $newUser = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'ecole_id' => $validated['ecole_id'],
            'telephone' => $validated['telephone'],
            'adresse' => $validated['adresse'],
            'ville' => $validated['ville'],
            'province' => $validated['province'],
            'code_postal' => $validated['code_postal'],
            'date_naissance' => $validated['date_naissance'],
            'sexe' => $validated['sexe'],
            'active' => true,
            'email_verified_at' => now()
        ]);

        $newUser->assignRole($validated['role']);

        activity()
            ->causedBy($user)
            ->performedOn($newUser)
            ->log('Utilisateur créé');

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès');
    }

    /**
     * Modification d'utilisateur
     */
    public function edit(User $user)
    {
        $currentUser = Auth::user();
        
        // Vérifications d'autorisation
        if ($currentUser->hasRole('admin')) {
            if ($user->ecole_id !== $currentUser->ecole_id) {
                abort(403, 'Vous ne pouvez modifier que les utilisateurs de votre école');
            }
        }

        if ($currentUser->hasRole('superadmin')) {
            $ecoles = Ecole::orderBy('nom')->get();
            $roles = Role::all();
        } else {
            $ecoles = collect([$currentUser->ecole]);
            $roles = Role::whereIn('name', ['user', 'instructeur'])->get();
        }

        return view('admin.users.edit', compact('user', 'ecoles', 'roles'));
    }

    /**
     * Mise à jour d'utilisateur
     */
    public function update(Request $request, User $user)
    {
        $currentUser = Auth::user();
        
        // Vérifications d'autorisation
        if ($currentUser->hasRole('admin')) {
            if ($user->ecole_id !== $currentUser->ecole_id) {
                abort(403);
            }
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'username' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'ecole_id' => 'required|exists:ecoles,id',
            'role' => 'required|exists:roles,name',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:50',
            'code_postal' => 'nullable|string|max:10',
            'date_naissance' => 'nullable|date',
            'sexe' => 'nullable|in:M,F,Autre',
            'active' => 'boolean'
        ];

        // Restrictions pour admin d'école
        if ($currentUser->hasRole('admin')) {
            $rules['ecole_id'] = [
                'required',
                Rule::in([$currentUser->ecole_id])
            ];
            $rules['role'] = [
                'required',
                Rule::in(['user', 'instructeur'])
            ];
        }

        $validated = $request->validate($rules);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'ecole_id' => $validated['ecole_id'],
            'telephone' => $validated['telephone'],
            'adresse' => $validated['adresse'],
            'ville' => $validated['ville'],
            'province' => $validated['province'],
            'code_postal' => $validated['code_postal'],
            'date_naissance' => $validated['date_naissance'],
            'sexe' => $validated['sexe']
        ];

        if ($currentUser->hasRole('superadmin')) {
            $updateData['active'] = $validated['active'] ?? false;
        }

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);
        
        // Mise à jour du rôle
        $user->syncRoles([$validated['role']]);

        activity()
            ->causedBy($currentUser)
            ->performedOn($user)
            ->log('Utilisateur modifié');

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès');
    }

    /**
     * Désactivation/Suppression
     */
    public function destroy(User $user)
    {
        $currentUser = Auth::user();
        
        // Vérifications
        if ($user->id === $currentUser->id) {
            return back()->with('error', 'Vous ne pouvez pas vous supprimer vous-même');
        }

        if ($currentUser->hasRole('admin')) {
            if ($user->ecole_id !== $currentUser->ecole_id) {
                abort(403);
            }
            // Admin d'école peut seulement désactiver
            $user->update(['active' => false]);
            $action = 'désactivé';
        } else {
            // SuperAdmin peut supprimer
            $user->delete();
            $action = 'supprimé';
        }

        activity()
            ->causedBy($currentUser)
            ->performedOn($user)
            ->log("Utilisateur {$action}");

        return redirect()->route('admin.users.index')
            ->with('success', "Utilisateur {$action} avec succès");
    }

    /**
     * Réactivation d'un utilisateur
     */
    public function activate(User $user)
    {
        $currentUser = Auth::user();
        
        if ($currentUser->hasRole('admin') && $user->ecole_id !== $currentUser->ecole_id) {
            abort(403);
        }

        $user->update(['active' => true]);

        activity()
            ->causedBy($currentUser)
            ->performedOn($user)
            ->log('Utilisateur réactivé');

        return back()->with('success', 'Utilisateur réactivé avec succès');
    }
}
