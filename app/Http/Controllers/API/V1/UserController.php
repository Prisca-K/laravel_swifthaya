<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserProfileResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\User_profile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
  public function show()
  {
    $user = Auth::user();
    
    Gate::authorize("view", Auth::user()->userprofile);

    try {
      return [
        "user" => new UserResource($user),
      ];
    } catch (Exception $e) {
      return response()->json([
        "message" => "Failed to retrieve User",
        "error" => $e->getMessage()
      ]);
    }
  }
  public function profile_img(Request $request)
  {
    try {
      DB::beginTransaction();
      // fetch userprofile
      $profile = User_profile::where("id", Auth::user()->userprofile->id)->first();

      // user authorization
      Gate::authorize("update", $profile);

      // validate image request
      $validated = $request->validate(['profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048']);


      if ($request->has("profile_picture")) {
        // stor file in public folder
        $imagePath = $request->file("profile_picture")->store("profile", "public");

        $validated = $imagePath;

        // deleting previous image to store new one 
        Storage::disk("public")->delete($profile->profile_picture ?? "");

        $profile->profile_picture = $validated;
        $profile->update(["profile_picture" => $validated]);
        DB::commit();
        return response()->json(["message" => "Profile picture Updated Successfully"]);
      }
      return response()->json(["error" => "No Profile picture selected"]);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json([
        "message" => "Failed to update Profile picture",
        "error" => $e->getMessage()
      ]);
    }
  }
  public function destroy(Request $request)
  {
    try {
      DB::beginTransaction();
      // Check if the authenticated user has permission to delete their own account
      Gate::authorize("delete", Auth::user()->userprofile);

      // Validate the request, ensuring the user provides their current password
      $request->validate([
        'password' => ['required', 'current_password'], // Laravel's 'current_password' rule checks if the password matches
      ]);


      // Get the authenticated user
      $user = $request->user();

      // Perform the deletion
      $user->delete();

      // Revoke the user's tokens to log them out from all devices
      $user->tokens()->delete();

      // Return a JSON response indicating the account deletion was successful
      DB::commit(); // Commit transaction

      return response()->json(["message" => "User account deleted successfully"]);
    } catch (Exception $e) {
      DB::rollBack(); // Rollback in case of failure
      return response()->json(['message' => 'Failed to delete user account', 'error' => $e->getMessage()], 500);
    }
  }
}
