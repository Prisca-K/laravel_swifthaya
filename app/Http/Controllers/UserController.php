<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompany_profileRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateCompany_profileRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Company_profile;
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
  public function edit()
  {
    // dd($profile->id);
    $user_profile = User_profile::where("user_id", Auth::user()->id)->first();
    
    Gate::authorize("update", $user_profile);
    return view('profile.edit', [
      'user' => Auth::user(),
      // "profile" => $user
    ]);
  }
  
  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateUserRequest $request)
  {
    $user = User::findorFail(Auth::user()->id);
    $profile = User_profile::where("id", $user->userprofile->id)->first();
    
    Gate::authorize("update", $profile);
    $validated = $request->validated();
    
    $user->update([
      'email' => $validated["email"],
      'password' => $user->password
    ]);
    

    // updating user profile
    $profile->update([
      'first_name' => ucfirst($validated["first_name"]),
      'last_name' => ucfirst($validated["last_name"]),
      'bio' => $validated["bio"],
      'location' => lcfirst($validated["location"]),
      'phone_number' => $validated["phone_number"],
      'website' => $validated["website"],
    ]);




    return redirect()->route('profile.edit')->with('status', 'profile-updated');
  }


  public function profile_img(Request $request)
  {
    // dd($user->id);
    $profile = User_profile::where("id", Auth::user()->userprofile->id)->first();
    Gate::authorize("update", $profile);
    $validated = $request->validate(['profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048']);


    if ($request->has("profile_picture")) {
      $imagePath = $request->file("profile_picture")->store("profile", "public");

      // dd($imagePath = $request->file("profile_picture"));
      $validated = $imagePath;

      Storage::disk("public")->delete($profile->profile_picture ?? "");

      $profile->profile_picture = $validated;
      $profile->update(["profile_picture" => $validated]);
      return redirect()->route('profile.edit')->with('status', 'profile-updated');
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
