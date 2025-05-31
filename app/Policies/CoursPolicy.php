<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Cours;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Cours $cours)
    {
        return $user->role === 'superadmin' || 
               ($user->ecole_id && $user->ecole_id == $cours->ecole_id);
    }

    public function create(User $user)
    {
        return $user->role === 'superadmin' || 
               ($user->role === 'admin' && $user->ecole_id);
    }

    public function update(User $user, Cours $cours)
    {
        return $user->role === 'superadmin' || 
               ($user->ecole_id && $user->ecole_id == $cours->ecole_id);
    }

    public function delete(User $user, Cours $cours)
    {
        return $user->role === 'superadmin' || 
               ($user->ecole_id && $user->ecole_id == $cours->ecole_id);
    }
}
