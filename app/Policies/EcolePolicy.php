<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ecole;

class EcolePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'superadmin';
    }

    public function view(User $user, Ecole $ecole): bool
    {
        if ($user->role === 'superadmin') return true;
        return $user->ecole_id === $ecole->id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'superadmin';
    }

    public function update(User $user, Ecole $ecole): bool
    {
        if ($user->role === 'superadmin') return true;
        return $user->ecole_id === $ecole->id;
    }

    public function delete(User $user, Ecole $ecole): bool
    {
        return $user->role === 'superadmin';
    }
}
