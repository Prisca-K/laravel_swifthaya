<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Project;
use App\Models\Swifthayajob;
use App\Models\Talent_profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
  // public function index(User $recieverId)
  // {
  //   $conversations = Message::where(["sender_id" => Auth::user()->id, "recipient_id" => $recieverId->id])->get();
  //   // dd($conversations->receiver);
  //   return view("messages", compact("conversations"));
  // }
  public function index(User $recipient)
  {
    $employerId = Auth::user()->id;

    // check if any candidates have applied to any job posted by the employer
    $checkJobCandidates = User::whereHas('applications', function ($query) use ($employerId) {
      $query->whereHas('swifthayajob', function ($subQuery) use ($employerId) {
        $subQuery->where('company_id', $employerId);
      });
    })->with('userprofile')->exists();

    $checkProjectCandidates = User::whereHas('applications', function ($query) use ($employerId) {
      $query->whereHas('project', function ($subQuery) use ($employerId) {
        $subQuery->where('poster_id', $employerId);
      });
    })->with('userprofile')->exists();

    // Fetch candidates who have applied to any job posted by the employer

    $checkCandidates = $checkProjectCandidates || $checkJobCandidates;


    $projectCandidates = false;
    $jobCandidates = false;

    if ($checkCandidates) {

      if ($checkJobCandidates) {
        // dd("yes");
        $jobCandidates = User::whereHas('applications', function ($query) use ($employerId) {
          $query->whereHas('swifthayajob', function ($subQuery) use ($employerId) {
            $subQuery->where('company_id', $employerId);
          });
        })->with('userprofile')->get();
      } else {
      }
      if ($checkProjectCandidates) {
        $projectCandidates = User::whereHas('applications', function ($query) use ($employerId) {
          $query->whereHas('project', function ($subQuery) use ($employerId) {
            $subQuery->where('poster_id', $employerId);
          });
        })->with('userprofile')->get();
        // dd($projectCandidates);
      } else {
      }
    }


    $conversations = Conversation::where('user_id', Auth::user()->id)
      ->orWhere('recipient_id', Auth::user()->id)
      ->with(['user', 'recipient', 'messages' => function ($query) {
        $query->latest();
      }])->get();
    // dd($recipient->id);
    $user = User::where("id", Auth::user()->id)->first();

    // dd($user->user_type);
    $canMessage = true;
    if ($user->user_type === "talent") {
      $canMessage = false;
    }
    $isNewConversation = false;
    if (count($conversations)  === 0) {
      $isNewConversation = true;
    }
    $activeConversation = false;
    return view('messages', compact('conversations', 'activeConversation', 'recipient', 'isNewConversation', 'canMessage', 'jobCandidates', 'projectCandidates', 'checkCandidates', 'checkJobCandidates', 'checkProjectCandidates'));
  }

  public function show(Conversation $id, User $recipient)
  {
    $activeConversation = Conversation::with(['user', 'recipient', 'messages' => function ($query) {
      $query->latest();
    }])->where("id", $id->id)->first();

    $user = User::where("id", Auth::user()->id)->first();

    // dd($user->user_type);
    $canMessage = true;
    if ($user->user_type === "talent") {
      $canMessage = false;
    }

    if ($activeConversation->user_id !== Auth::user()->id && $activeConversation->recipient_id !== Auth::user()->id) {
      abort(403, 'Unauthorized access to this conversation.');
    }
    // $isNewConversation = false;
    $employerId = Auth::user()->id;

    // check if any candidates have applied to any job posted by the employer
    $checkJobCandidates = User::whereHas('applications', function ($query) use ($employerId) {
      $query->whereHas('swifthayajob', function ($subQuery) use ($employerId) {
        $subQuery->where('company_id', $employerId);
      });
    })->with('userprofile')->exists();
    // $checkProjectCandidates = false;
    $checkProjectCandidates = User::whereHas('applications', function ($query) use ($employerId) {
      $query->whereHas('project', function ($subQuery) use ($employerId) {
        $subQuery->where('poster_id', $employerId);
      });
    })->with('userprofile')->exists();
    // Fetch candidates who have applied to any job posted by the employer
    $checkCandidates = $checkProjectCandidates || $checkJobCandidates;

    $projectCandidates = false;
    $jobCandidates = false;
    if ($checkCandidates) {

      if ($checkJobCandidates) {
        // dd("yes");
        $jobCandidates = User::whereHas('applications', function ($query) use ($employerId) {
          $query->whereHas('swifthayajob', function ($subQuery) use ($employerId) {
            $subQuery->where('company_id', $employerId);
          });
        })->with('userprofile')->get();
      } else {
        $jobCandidates = false;
      }
      if ($checkProjectCandidates) {
        $projectCandidates = User::whereHas('applications', function ($query) use ($employerId) {
          $query->whereHas('project', function ($subQuery) use ($employerId) {
            $subQuery->where('poster_id', $employerId);
          });
        })->with('userprofile')->get();
        // dd($projectCandidates);
      } else {
        $projectCandidates = false;
      }
    }
    $conversations = Conversation::where('user_id', Auth::user()->id)
      ->orWhere('recipient_id', Auth::user()->id)
      ->get();
    // dd($projectCandidates);
    return view(
      'messages',
      compact(
        'canMessage',
        'checkCandidates',
        'checkJobCandidates',
        'checkProjectCandidates',
        'jobCandidates',
        'projectCandidates',
        'recipient',
        'activeConversation',
        'conversations'
      )
    );
  }

  // conversation
  public function store_conversation(User $recipient)
  {
    $user = User::where("id", Auth::user()->id)->first();

    // dd($recipient->user_type);
    if ($user->user_type === "talent") {
      abort(403, "Access Denied");
    }

    if ($recipient->user_type === "company" || $recipient->user_type === "individual") {
      return redirect()->route('messages.index', $recipient->id)->with('error', "Can't create conversation with an employer");
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
        return redirect()->route('messages.index', $recipient->id)->with('error', "Can't create conversation with candidate who has not applied");
      }
    }
    if ($user->user_type === "individual") {
      $employerId = $user->id;
      $hasApplied = Application::whereHas('project', function ($query) use ($employerId) {
        $query->where('poster_id', $employerId);
      })->where('applicant_id', $recipient->id)->exists();
      if ($hasApplied === false) {
        // dd("existnot");
        return redirect()->route('messages.index', $recipient->id)->with('error', "Can't create conversation with candidate who has not applied");
      }
    }

    $conversationExists =  Conversation::where(["user_id" => Auth::user()->id, "recipient_id" => $recipient->id])->exists();

    // dd($conversationExists, $recipient->id);
    if ($conversationExists === true) {
      return redirect()->route('messages.index', $recipient->id)->with('error', "Can't create conversation with the same candidate twice");
    }
    $conversation = Conversation::create([
      'recipient_id' => $recipient->id,
      'user_id' => Auth::user()->id,
    ]);

    // dd($conversation);
    if ($conversation->user_id !== Auth::user()->id && $conversation->recipient_id !== Auth::user()->id) {
      abort(403, 'Unauthorized access to this conversation.');
    }
    return redirect()->route('messages.index', $recipient->id)->with('success', 'Message sent successfully.');
  }

  public function store(Request $request, User $recipient)
  {
    $user = User::where("id", Auth::user()->id)->first();
    // $chat = Conversation::where('recipient_id', Auth::user()->id)->first();
    // $employerId = $chat->user_id;
    if ($user->user_type === "talent") {
      $hasMessaged = Message::where('sender_id', $recipient->id)
        ->where('recipient_id', Auth::user()->id)
        ->exists();
      // dd($hasMessaged, $recipient->id);
      if (!$hasMessaged) {
        return redirect()->route('messages.index', $recipient->id)->with('error', "Can't send messages, till employer sends first message");
      }
    }

    $validated = $request->validate([
      'conversation_id' => 'required|exists:conversations,id',
      'message' => 'required|string|max:1000',
    ]);

    $conversation = Conversation::findOrFail($validated['conversation_id']);

    if ($conversation->user_id !== Auth::user()->id && $conversation->recipient_id !== Auth::user()->id) {
      abort(403, 'Unauthorized access to this conversation.');
    }
    // dd($recipient->id, Auth::user()->id);
    $message = $conversation->messages()->create([
      'recipient_id' => $recipient->id,
      'sender_id' => Auth::user()->id,
      'content' => $validated['message'],
      'status'
    ]);

    return redirect()->route('messages.index')->with('success', 'Message sent successfully.');
  }
}
