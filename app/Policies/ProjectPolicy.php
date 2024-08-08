<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Project $project): bool
    {
       return ($user->user_type === "admin" || $user->id === $project->poster_id);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
      return ($user->user_type === "admin" || $user->id === $project->poster_id);

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
      return ($user->user_type === "admin" || $user->id === $project->poster_id);
    }

   
}
