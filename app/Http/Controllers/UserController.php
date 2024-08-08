<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Models\User_profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
  public function edit(User_profile $profile)
  {
    Gate::authorize("update", $profile);
    return view('profile.edit', [
      'user' => auth()->user(),
      "profile" => $profile
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(StoreUserRequest $request, User_profile $profile)
  {
    Gate::authorize("update", $profile);
    $user = User::where("id", $profile->user_id)->first();
    $validated = $request->validated();

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

    return redirect()->route('profile.edit', $profile->id)->with('status', 'profile-updated');
  }
  public function profile_img(Request $request, User_profile $profile)
  {
    Gate::authorize("update", $profile);
    $validated = $request->validate(['profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048']);
    // updating user profile
    // $profile->update([
      //   'user_id' => auth()->id(),
      //   'first_name' => ucfirst($validated["first_name"]),
    //   'last_name' => ucfirst($validated["last_name"]),
    //   'profile_picture' => $validated["profile_picture"],
    // ]);


    if ($request->has("profile_picture")) {
      $imagePath = $request->file("profile_picture")->store("profile", "public");

      // dd($imagePath = $request->file("profile_picture"));
      $validated = $imagePath;

      Storage::disk("public")->delete($profile->profile_picture ?? "");

      $profile->profile_picture = $validated;
      $profile->update(["profile_picture" => $validated]);
    return redirect()->route('profile.edit', $profile->id)->with('status', 'profile-updated');
  }
}
  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request): RedirectResponse
  {
    Gate::authorize("destroy", $request->user());
    $request->validateWithBag('userDeletion', [
      'password' => ['required', 'current_password'],
    ]);

    $user = $request->user();

    Auth::logout();

    $user->delete();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return Redirect::to('/');
  }
}
