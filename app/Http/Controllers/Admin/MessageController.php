<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
  public function index()
  {
    $messages = Message::with('sender', 'receiver')->paginate(10);
    return view('admin.messages.index', compact('messages'));
  }

  public function show(Message $message)
  {
    return view('admin.messages.show', compact('message'));
  }

  public function destroy(Message $message)
  {
    $message->delete();
    return redirect()->route('admin.messages')->with('success', 'Message deleted successfully.');
  }
}
