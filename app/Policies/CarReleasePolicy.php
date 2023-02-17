<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CarRelease;
use Illuminate\Auth\Access\HandlesAuthorization;

class CarReleasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view_any_car::release');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CarRelease  $carRelease
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, CarRelease $carRelease)
    {
        return $user->can('view_car::release');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_car::release');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CarRelease  $carRelease
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, CarRelease $carRelease)
    {
        return $user->can('update_car::release');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CarRelease  $carRelease
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, CarRelease $carRelease)
    {
        return $user->can('delete_car::release');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user)
    {
        return $user->can('delete_any_car::release');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CarRelease  $carRelease
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, CarRelease $carRelease)
    {
        return $user->can('force_delete_car::release');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user)
    {
        return $user->can('force_delete_any_car::release');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CarRelease  $carRelease
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, CarRelease $carRelease)
    {
        return $user->can('restore_car::release');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('restore_any_car::release');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CarRelease  $carRelease
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, CarRelease $carRelease)
    {
        return $user->can('replicate_car::release');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user)
    {
        return $user->can('reorder_car::release');
    }

}
