<?php

namespace App\Policies;

use App\Enums\RoleName;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([RoleName::ADMIN, RoleName::MANAGER, RoleName::DEVELOPER]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        return $user->hasAnyRole([RoleName::ADMIN, RoleName::MANAGER, RoleName::DEVELOPER]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole([RoleName::ADMIN, RoleName::MANAGER, RoleName::DEVELOPER]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        if ($user->hasAnyRole([RoleName::ADMIN, RoleName::MANAGER])) {
            return true;
        } elseif (($user->id == $task->author->id)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        if ($user->hasAnyRole([RoleName::ADMIN, RoleName::MANAGER])) {
            return true;
        } elseif (($user->id == $task->author->id)) {
            return true;
        }
        return false;
    }
}
