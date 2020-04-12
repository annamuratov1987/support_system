<?php

namespace App\Policies;

use App\Complaint;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComplaintPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Complaint  $complaint
     * @return mixed
     */
    public function view(User $user, Complaint $complaint)
    {
        return $user->id == $complaint->user_id || $user->isManager();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return !$user->isManager();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Complaint  $complaint
     * @return mixed
     */
    public function update(User $user, Complaint $complaint)
    {
        return $user->id == $complaint->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Complaint  $complaint
     * @return mixed
     */
    public function delete(User $user, Complaint $complaint)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Complaint  $complaint
     * @return mixed
     */
    public function restore(User $user, Complaint $complaint)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Complaint  $complaint
     * @return mixed
     */
    public function forceDelete(User $user, Complaint $complaint)
    {
        //
    }

    public function answer(User $user, Complaint $complaint){
        return $user->id == $complaint->user_id || $user->isManager();
    }
}
