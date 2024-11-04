<?php

namespace App\Policies;

use App\Models\Thuoc;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThuocPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any Thuoc models.
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['quản lý', 'nhân viên']);
    }

    /**
     * Determine whether the user can view the Thuoc model.
     */
    public function view(User $user, Thuoc $thuoc)
    {
        return $user->hasAnyRole(['quản lý', 'nhân viên']);
    }

    /**
     * Determine whether the user can create Thuoc models.
     */
    public function create(User $user)
    {
        return $user->hasRole('quản lý');
    }

    /**
     * Determine whether the user can update the Thuoc model.
     */
    public function update(User $user, Thuoc $thuoc)
    {
        return $user->hasRole('quản lý');
    }

    /**
     * Determine whether the user can delete the Thuoc model.
     */
    public function delete(User $user, Thuoc $thuoc)
    {
        return $user->hasRole('quản lý');
    }
}
