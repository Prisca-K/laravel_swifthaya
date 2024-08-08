<?php

namespace App\Policies;

use App\Models\User;
use App\Models\User_profile;
use Illuminate\Auth\Access\Response;

class User_profilePolicy
{
  public function view(User $user, User_profile $user_profile): bool
  {
    return ($user->user_type === "admin" || $user->userprofile->id === $user_profile->id);
  }


  /**
   * Determine whether the user can update the model.
   */
  public function update(User $user, User_profile $user_profile): bool
  {
    return ($user->user_type === "admin" || $user->userprofile->id === $user_profile->id);
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function delete(User $user, User_profile $user_profile): bool
  {
    return ($user->user_type === "admin" || $user->userprofile->id === $user_profile->id);
  }
}
