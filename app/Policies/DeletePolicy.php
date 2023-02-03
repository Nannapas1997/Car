<?php

namespace App\Policies;
use App\Providers\AuthServiceProvider;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use SebastianBergmann\Type\VoidType;

class DeletePolicy
{
    use HandlesAuthorization, AuthServiceProvider;
    public function delete() {
        return false;
    }
    public function deleteAny() {
        return false;
    }
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    function forceDelete() {
        return false;
    }
    function forceDeleteAny() {
        return false;
    }
    public function __construct()
    {

    }
}
