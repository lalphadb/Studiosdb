<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cours;

class CoursPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'admin']);
    }

    public function view(User $user, Cours $cours): bool
    {
        if ($user->role === 'superadmin') return true;
        return $user->ecole_id === $cours->ecole_id;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['superadmin', 'admin']);
    }

    public function update(User $user, Cours $cours): bool
    {
        if ($user->role === 'superadmin') return true;
        return $user->ecole_id === $cours->ecole_id;
    }

    public function delete(User $user, Cours $cours): bool
    {
        if ($user->role === 'superadmin') return true;
        return $user->ecole_id === $cours->ecole_id;
    }
}
