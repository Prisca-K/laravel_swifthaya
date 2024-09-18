<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserProfileResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use App\Models\User_profile;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

  public function register(RegisterUserRequest $request)
  {
    // Validate the request data
    $validated = $request->validated();

    // Create the user
    $user = User::create([
      'email' => $validated["email"],
      'password' => Hash::make($validated["password"]),
      'user_type' => $validated["user_type"],
      'last_login_at' => now()
    ]);

    // Create the user profile if user creation is successful
    if ($user) {
      User_profile::create([
        'user_id' => $user->id,
        'first_name' => ucfirst($validated["first_name"]),
        'last_name' => ucfirst($validated["last_name"]),
      ]);

      // Create an API token (if using Sanctum or JWT)
      $token = $user->createToken('API Token')->plainTextToken;

      // Return a success response with the token and user details
      return [
        "user" => new UserResource($user),
        "user_profile" => new UserProfileResource($user->userprofile),
        "token" => $token
      ];  // Use resource to format the response

    }

    return response()->json(['message' => 'User registration failed'], 500);
  }

  public function login(LoginUserRequest $request)
  {
    $validated = $request->validated();

    $user = User::where("email", $validated["email"])->first();
    if (!$user || !Hash::check($validated["password"], $user->password)) {
      return response()->json([
        "message" => "The provided credentials are incorrect"
      ]);
    }
    $token = $user->createToken('API Token')->plainTextToken;
    return response()->json([
      'message' => 'login successful',
      'token' => $token,
    ], 200);
  }

  public function logout(Request $request)
  {
    $request->user()->tokens()->delete();
    return [
      'message' => 'logout successful'
    ];
  }
}
