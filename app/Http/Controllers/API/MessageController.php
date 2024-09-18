<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\MessageResource;
use App\Models\Application;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
  public function conversations()
  {

    $conversations = Conversation::where('user_id', Auth::user()->id)
      ->orWhere('recipient_id', Auth::user()->id)
      ->with(['user', 'recipient', 'messages' => function ($query) {
        $query->latest();
      }])->get();
    return ConversationResource::collection($conversations);

    // if ($conversation->user_id !== Auth::user()->id && $conversation->recipient_id !== Auth::user()->id) {
    //   abort(403, 'Unauthorized access to this conversation.');
    // }
  }
  public function messages()
  {

    $messages = Message::where('sender_id', Auth::user()->id)
      ->orWhere('recipient_id', Auth::user()->id)
      ->with(['user', 'recipient', 'messages' => function ($query) {
        $query->latest();
      }])->get();
    return MessageResource::collection($messages);

    // if ($conversation->user_id !== Auth::user()->id && $conversation->recipient_id !== Auth::user()->id) {
    //   abort(403, 'Unauthorized access to this conversation.');
    // }
  }
  public function store_conversation(User $recipient)
  {
    $user = User::where("id", Auth::user()->id)->first();

    if ($user->user_type === "talent") {
      return redirect()->route('conversations.index')->with('error', "Only employers can start conversations");
    }

    if ($recipient->user_type === "company" || $recipient->user_type === "individual") {
      return redirect()->route('conversations.index')->with('error', "Can't create conversation with an employer");
    }

    if ($user->user_type === "company") {
      $employerId = $user->id;
      $hasAppliedJob = Application::whereHas('swifthayajob', function ($query) use ($employerId) {
        $query->where('company_id', $employerId);
      })->where('applicant_id', $recipient->id)->exists();
      // project
      $hasAppliedProject = Application::whereHas('project', function ($query) use ($employerId) {
        $query->where('poster_id', $employerId);
      })->where('applicant_id', $recipient->id)->exists();
      // dd($hasAppliedProject);
      if ($hasAppliedJob === false && $hasAppliedProject === false) {
        return redirect()->route('conversations.index')->with('error', "Can't create conversation with candidate who has not applied");
      }
    }
    if ($user->user_type === "individual") {
      $employerId = $user->id;
      $hasApplied = Application::whereHas('project', function ($query) use ($employerId) {
        $query->where('poster_id', $employerId);
      })->where('applicant_id', $recipient->id)->exists();
      if ($hasApplied === false) {
        // dd("existnot");
        return redirect()->route('conversations.index')->with('error', "Can't create conversation with candidate who has not applied");
      }
    }

    $conversationExists =  Conversation::where(["user_id" => Auth::user()->id, "recipient_id" => $recipient->id])->exists();

    // dd($conversationExists, $recipient->id);
    if ($conversationExists === true) {
      return redirect()->route('conversations.index')->with('error', "Can't create conversation with the same candidate twice");
    }
    $conversation = Conversation::create([
      'recipient_id' => $recipient->id,
      'user_id' => Auth::user()->id,
    ]);

    // dd($conversation);
    if ($conversation->user_id !== Auth::user()->id && $conversation->recipient_id !== Auth::user()->id) {
      abort(403, 'Unauthorized access to this conversation.');
    }
    return redirect()->route('conversations.index')->with('success', 'Message sent successfully.');
  }
}
