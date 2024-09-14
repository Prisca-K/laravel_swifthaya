<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\User_profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  public function index()
  {
    $users = User::with("userprofile")->paginate(10);
    return view('admin.users.index', compact('users'));
  }

  public function create()
  {
    return view('admin.users.create');
  }

  public function store(StoreUserRequest $request)
  {
    $validated = $request->validated();

    $user = User::create([
      'email' => $validated["email"],
      'password' => Hash::make($validated["password"]),
      'user_type' => $validated["user_type"],
    ]);

    // creating user profile
    if ($user) {
      $profile =  User_profile::create([
        'user_id' => $user->id,
        'first_name' => ucfirst($validated["first_name"]),
        'last_name' => ucfirst($validated["last_name"]),
      ]);
    }

    if ($user->user_type === "talent") {
      return redirect()->route("admin.talents.create", $profile->id);
    }
    if ($user->user_type === "company") {
      return redirect()->route("admin.companies.create", $profile->id);
    }
    return redirect()->route('admin.users')->with('success', 'User created successfully.');
  }

  public function edit(User $user)
  {
    return view('admin.users.edit', compact('user'));
  }

  public function update(UpdateUserRequest $request, User $user)
  {
    $validated = $request->validated();

    $profile = User_profile::where("user_id", $user->id)->first();
    // dd($profile);

    $user->update([
      'email' => $validated["email"],
      'password' => $user->password
    ]);

    // updating user profile
    $profile->update([
      'user_id' => $user->id,
      'first_name' => ucfirst($validated["first_name"]),
      'last_name' => ucfirst($validated["last_name"]),
      // 'profile_picture' => $validated["profile_picture"],
      'bio' => $validated["bio"],
      'location' => $validated["location"],
      'phone_number' => $validated["phone_number"],
      'website' => $validated["website"],
    ]);

    return redirect()->route('admin.users')->with('success', 'User updated successfully.');
  }

  public function destroy(User $user)
  {
    $user->delete();
    return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
  }
  // Approve User
  public function approveUser(User $user)
  {
    $user = User::where("id", $user->id);
    $status = $user->status = 'approved';
    $user->update(["status" => $status]);

    return redirect()->route('admin.users')->with('success', 'User has been approved successfully.');
  }

  // Reject User
  public function rejectUser(User $user)
  {
    $user = User::where("id", $user->id);
    $status = $user->status = 'rejected';
    $user->update(["status" => $status]);

    return redirect()->route('admin.users')->with('error', 'User has been rejected.');
  }
}
