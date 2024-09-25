<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MessagePolicy
{

  public function modify(User $user, Message $message): bool
  {
    return ($user->user_type === "admin" || $user->id ===  $message->sender->id);
  }
}
