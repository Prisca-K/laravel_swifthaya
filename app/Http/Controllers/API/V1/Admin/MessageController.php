<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConversationResource;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Models\Message;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class MessageController extends Controller
{
  // Fetch a list of conversations with pagination
  public function conversations()
  {
    try {
      // Fetch conversations and paginate (latest first)
      $conversations = Conversation::latest()->paginate(10);

      // Return paginated conversations as a resource collection
      return ConversationResource::collection($conversations);
    } catch (Exception $e) {
      // Return error response if exception occurs
      return response()->json(['message' => 'Failed to retrieve conversations', 'error' => $e->getMessage()], 500);
    }
  }

  // Fetch a list of messages with pagination
  public function messages()
  {
    try {
      // Fetch messages and paginate (latest first)
      $messages = Message::latest()->paginate(10);

      // Return paginated messages as a resource collection
      return MessageResource::collection($messages);
    } catch (Exception $e) {
      // Return error response if exception occurs
      return response()->json(['message' => 'Failed to retrieve messages', 'error' => $e->getMessage()], 500);
    }
  }
  // Fetch a single conversation
  public function ShowConversation(Conversation $conversation)
  {
    try {

      return new ConversationResource($conversation);
    } catch (Exception $e) {
      // Return error response if exception occurs
      return response()->json(['conversation' => 'Failed to retrieve conversation', 'error' => $e->getMessage()], 500);
    }
  }
  // Fetch a single message
  public function ShowMessage(Message $message)
  {
    try {
      return new MessageResource($message);
    } catch (Exception $e) {
      // Return error response if exception occurs
      return response()->json(['message' => 'Failed to retrieve message', 'error' => $e->getMessage()], 500);
    }
  }

  // Delete a specific conversation 
  public function destroyConversation(Conversation $conversation)
  {
    Gate::authorize("modify", $conversation);
    DB::beginTransaction(); // Start database transaction

    try {
      // Delete conversation
      $conversation->delete();

      // Commit transaction
      DB::commit();

      // Return success response
      return response()->json(['message' => 'Conversation deleted successfully'], 200);
    } catch (Exception $e) {
      // Rollback transaction on failure
      DB::rollBack();

      // Return error response
      return response()->json(['message' => 'Failed to delete conversation', 'error' => $e->getMessage()], 500);
    }
  }


  // Delete a specific message
  public function destroyMessage(Message $message)
  {
    Gate::authorize("modify", $message);

    DB::beginTransaction(); // Start database transaction

    try {
      // Delete message
      $message->delete();

      // Commit transaction
      DB::commit();

      // Return success response
      return response()->json(['message' => 'Message deleted successfully'], 200);
    } catch (Exception $e) {
      // Rollback transaction on failure
      DB::rollBack();

      // Return error response
      return response()->json(['message' => 'Failed to delete message', 'error' => $e->getMessage()], 500);
    }
  }
}
