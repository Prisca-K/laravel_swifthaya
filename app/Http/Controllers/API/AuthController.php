<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use App\Models\User_profile;

class AuthController extends Controller
{

  public function register(Request $request)
  {
    // Validate the request
    $validated = $request->validate([
      'first_name' => ['required', 'string', 'max:255'],
      'last_name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
      'user_type' => ['required', 'in:company,individual,talent,admin'],
    ]);

    // Create the user
    $user = User::create([
      'email' => $validated["email"],
      'password' => Hash::make($validated["password"]),
      'user_type' => $validated["user_type"],
    ]);

    // Create the user profile if the user is created
    if ($user) {
      User_profile::create([
        'user_id' => $user->id,
        'first_name' => ucfirst($validated["first_name"]),
        'last_name' => ucfirst($validated["last_name"]),
      ]);

      // If using JWT or Sanctum, create a token
      $token = $user->createToken('API Token')->plainTextToken;

      // Return success response with user data and token
      return response()->json([
        'message' => 'Registration successful',
        'user' => $user,
        'profile' => $user->profile,
        'token' => $token,  // Include token for authentication
      ], 201); // 201 indicates resource creation
    }
    if (!$validated) {
      // If something goes wrong, return a generic error
      return response()->json(['message' => 'User registration failed'], 500);
    }
  }
  public function login(string $id)
  {
    return "register";
  }

  /**
   * Update the specified resource in storage.
   */

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
