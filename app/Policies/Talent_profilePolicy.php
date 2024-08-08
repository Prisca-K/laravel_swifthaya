<?php

namespace App\Policies;

use App\Models\Talent_profile;
use App\Models\User;
use App\Models\User_profile;
use Illuminate\Auth\Access\Response;

class Talent_profilePolicy
{

  public function view(User $user, Talent_profile $talentProfile): bool
  {
    return ($user->user_type === "admin" || $user->userprofile->id === $talentProfile->user_profile_id);
  }
  public function update(User $user, Talent_profile $talentProfile): bool
  {
    return ($user->user_type === "admin" || $user->userprofile->id === $talentProfile->user_profile_id);
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function delete(User $user, Talent_profile $talentProfile): bool
  {
    return ($user->user_type === "admin" || $user->userprofile->id === $talentProfile->user_profile_id);
  }
}
