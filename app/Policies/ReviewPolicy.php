<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReviewPolicy
{

  /**
   * Determine whether the user can update the model.
   */
  public function update(User $user, Review $review): bool
  {
    return $user->user_type === "admin" || $user->id === $review->reviewer_id;
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function delete(User $user, Review $review): bool
  {
    return $user->user_type === "admin" || $user->id === $review->reviewer_id;
  }
}
