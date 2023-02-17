<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ApprovalRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApprovalRequestPolicy
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
        return $user->can('view_any_approval::request');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ApprovalRequest  $approvalRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ApprovalRequest $approvalRequest)
    {
        return $user->can('view_approval::request');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_approval::request');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ApprovalRequest  $approvalRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ApprovalRequest $approvalRequest)
    {
        return $user->can('update_approval::request');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ApprovalRequest  $approvalRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ApprovalRequest $approvalRequest)
    {
        return $user->can('delete_approval::request');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user)
    {
        return $user->can('delete_any_approval::request');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ApprovalRequest  $approvalRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ApprovalRequest $approvalRequest)
    {
        return $user->can('force_delete_approval::request');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user)
    {
        return $user->can('force_delete_any_approval::request');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ApprovalRequest  $approvalRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ApprovalRequest $approvalRequest)
    {
        return $user->can('restore_approval::request');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('restore_any_approval::request');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ApprovalRequest  $approvalRequest
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, ApprovalRequest $approvalRequest)
    {
        return $user->can('replicate_approval::request');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user)
    {
        return $user->can('reorder_approval::request');
    }

}
