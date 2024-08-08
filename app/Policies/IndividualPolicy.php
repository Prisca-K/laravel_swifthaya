<?php

namespace App\Policies;

use App\Models\Individual;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class IndividualPolicy
{

  public function view(User $user, Project $project): bool
  {
    return ($user->user_type === "admin" || $user->id === $project->poster_id);
  }

 
}
