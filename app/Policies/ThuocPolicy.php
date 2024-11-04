<?php

namespace App\Policies;

use App\Models\Thuoc;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThuocPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['quản lý', 'nhân viên']);
    }

    public function view(User $user, Thuoc $thuoc)
    {
        return $user->hasAnyRole(['quản lý', 'nhân viên']);
    }

    public function create(User $user)
    {
        return $user->hasRole('quản lý');
    }

    public function update(User $user, Thuoc $thuoc)
    {
        return $user->hasRole('quản lý');
    }

    public function delete(User $user, Thuoc $thuoc)
    {
        return $user->hasRole('quản lý');
    }
}
