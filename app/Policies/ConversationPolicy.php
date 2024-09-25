<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ConversationPolicy
{
  /**
   * Determine whether the user can permanently delete the model.
   */
  public function modify(User $user, Conversation $conversation): bool
  {
    return ($user->user_type === "admin" || $user->id ===  $conversation->user->id);
  }
}
