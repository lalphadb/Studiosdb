<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Membre;

class MembrePolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'admin']);
    }

    public function view(User $user, Membre $membre): bool
    {
        if ($user->role === 'superadmin') return true;
        return $user->ecole_id === $membre->ecole_id;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'admin']);
    }

    public function update(User $user, Membre $membre): bool
    {
        if ($user->role === 'superadmin') return true;
        return $user->ecole_id === $membre->ecole_id;
    }

    public function delete(User $user, Membre $membre): bool
    {
        if ($user->role === 'superadmin') return true;
        return $user->ecole_id === $membre->ecole_id;
    }
}
