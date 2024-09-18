<?php

namespace App\Policies;

use App\Models\Company_profile;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class Company_profilePolicy
{
  // public function iscompanyprofile(User $user, Company_profile $company_profile): bool
  // {
  //   return ($user->user_type === "admin" || $user->userprofile->id === $company_profile->user_profile_id);
  // }
  public function modify(User $user, Company_profile $company_profile): Response
  {
    return ($user->user_type === "admin" || $user->userprofile->id === $company_profile->user_profile_id) ? Response::allow("user allowed") : Response::deny('User does not own this profile');
  }
  public function view(User $user, Company_profile $company_profile): bool
  {
    return ($user->user_type === "admin" || $user->userprofile->id === $company_profile->user_profile_id);
  }
  public function update(User $user, Company_profile $company_profile): bool
  {
    return ($user->user_type === "admin" || $user->userprofile->id === $company_profile->user_profile_id);
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function delete(User $user, Company_profile $company_profile): bool
  {
    return ($user->user_type === "admin" || $user->userprofile->id === $company_profile->user_profile_id);
  }
}
