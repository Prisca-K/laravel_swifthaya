<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\MessageResource;
use App\Models\Application;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Gate;

class MessageController extends Controller
{
  public function conversations()
  {
    try {
      $conversations = Conversation::where('user_id', Auth::user()->id)
        ->orWhere('recipient_id', Auth::user()->id)
        ->latest()
        ->get();
      return ConversationResource::collection($conversations);
    } catch (Exception $e) {
      return response()->json(['message' => 'Failed to retrieve conversations', 'error' => $e->getMessage()], 500);
    }
  }

  public function messages()
  {
    try {
      $messages = Message::where('sender_id', Auth::user()->id)
        ->orWhere('recipient_id', Auth::user()->id)
        ->latest()
        ->get();

      return MessageResource::collection($messages);
    } catch (Exception $e) {
      return response()->json(['message' => 'Failed to retrieve messages', 'error' => $e->getMessage()], 500);
    }
  }

  public function store_conversation_and_message(User $recipient, Request $request)
  {
    DB::beginTransaction(); // Begin transaction

    try {
      $user = Auth::user();
      // Check if conversation already exists
      $conversation = Conversation::where(function ($query) use ($user, $recipient) {
        $query->where('user_id', $user->id)
          ->where('recipient_id', $recipient->id);
      })->orWhere(function ($query) use ($user, $recipient) {
        $query->where('user_id', $recipient->id)
          ->where('recipient_id', $user->id);
      })->first();


      // If conversation does not exist,create conversation
      if (is_null($conversation)) {


        // Only allow employers to start conversations
        if ($user->user_type === "talent") {
          return response()->json([
            "message" => "Only employers can start conversations"
          ]);
        }

        // Prevent conversations between employers
        if ($recipient->user_type === "company" || $recipient->user_type === "individual") {
          return response()->json([
            "message" => "Can't create conversation with an employer"
          ]);
        }

        // Check if candidate has applied to jobs or projects (company or individual)
        if ($user->user_type === "company" || $user->user_type === "individual") {
          $employerId = $user->id;

          $hasAppliedJob = Application::whereHas('swifthayajob', function ($query) use ($employerId) {
            $query->where('company_id', $employerId);
          })->where('applicant_id', $recipient->id)->exists();

          $hasAppliedProject = Application::whereHas('project', function ($query) use ($employerId) {
            $query->where('poster_id', $employerId);
          })->where('applicant_id', $recipient->id)->exists();

          if (!$hasAppliedJob && !$hasAppliedProject) {
            return response()->json([
              "message" => "Can't create conversation with candidate who has not applied"
            ]);
          }
        }


        // Create a new conversation
        $conversation = Conversation::create([
          'recipient_id' => $recipient->id,
          'user_id' => $user->id,
        ]);


        // Employer must send first message
        if ($user->user_type === "talent") {
          $hasMessaged = Message::where('sender_id', $recipient->id)
            ->where('recipient_id', $user->id)
            ->exists();

          if (!$hasMessaged) {
            return response()->json([
              "message" => "Can't send messages, till employer sends first message"
            ]);
          }
        }

        // Validate message content
        $validated = $request->validate([
          'content' => 'required|string|max:1000',
        ]);

        // Store the message in the newly created conversation
        $message = $conversation->messages()->create([
          'recipient_id' => $recipient->id,
          'sender_id' => $user->id,
          'content' => $validated['content'],
          'status' => 'sent',
          'sent_at' => now(),
        ]);

        DB::commit(); // Commit transaction

        return response()->json([
          "message" => "Conversation created and message sent successfully",
          "conversation" => new ConversationResource($conversation),
          "message_data" => new MessageResource($message)
        ], 201);
      }


      // if conversation exists

      // Employer must send first message
      if ($user->user_type === "talent") {
        $hasMessaged = Message::where('sender_id', $recipient->id)
          ->where('recipient_id', $user->id)
          ->exists();

        if (!$hasMessaged) {
          return response()->json([
            "message" => "Can't send messages, till employer sends first message"
          ]);
        }
      }

      // Validate message content
      $validated = $request->validate([
        'content' => 'required|string|max:1000',
      ]);

      // Store the message in the newly created conversation
      $message = $conversation->messages()->create([
        'recipient_id' => $recipient->id,
        'sender_id' => $user->id,
        'content' => $validated['content'],
        'status' => 'sent',
        'sent_at' => now(),
      ]);

      DB::commit(); // Commit transaction

      return response()->json([
        "message" => "Message sent successfully",
        "message_data" => new MessageResource($message)
      ], 201);
    } catch (Exception $e) {
      DB::rollBack(); // Rollback in case of failure
      return response()->json(['message' => 'Failed to create conversation or send message', 'error' => $e->getMessage()], 500);
    }
  }

  // add gates
  public function destroyConversation(Conversation $conversation)
  {
    Gate::authorize("modify", $conversation);

    DB::beginTransaction();
    try {
      $conversation->delete();
      DB::commit();
      return response()->json(['message' => 'Conversation deleted successfully']);
    } catch (Exception $e) {
      return response()->json(['message' => 'Failed to delete conversation', 'error' => $e->getMessage()], 500);
    }
  }

  public function destroyMessage(Message $message)
  {
    Gate::authorize("modify", $message);

    DB::beginTransaction();
    try {
      $message->delete();
      DB::commit();
      return response()->json(['message' => 'Message deleted successfully']);
    } catch (Exception $e) {
      return response()->json(['message' => 'Failed to delete message', 'error' => $e->getMessage()], 500);
    }
  }
}
