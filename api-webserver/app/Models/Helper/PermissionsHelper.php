<?php

namespace App\Models\Helper;

use App\Models\User;
use Illuminate\Support\Collection;

/**
 *
 */
class PermissionsHelper
{
    /**
     * Return all permission of User
     *
     * @param User $user
     * @return Collection
     */
    static function getAllPermissions(User $user): Collection
    {
        $permissions = new Collection;

        foreach ($user->permissions as $permission) {
            $permissions->add($permission);
        }
        foreach ($user->roles as $role) {
            foreach ($role->permissions as $permission) {
                $permissions->add($permission);
            }
        }
        return $permissions->unique();

    }

}
