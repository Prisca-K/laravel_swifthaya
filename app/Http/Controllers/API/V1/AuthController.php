<?php

namespace App\Http\Controllers\API\V1;

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
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

  public function register(RegisterUserRequest $request)
  {
    DB::beginTransaction(); // Start transaction

    try {
      // Validate the request data
      $validated = $request->validated();

      // Create the user
      $user = User::create([
        'email' => $validated["email"],
        'password' => Hash::make($validated["password"]),
        'user_type' => $validated["user_type"],
        'status' => now(),
      ]);

      // Create the user profile if user creation is successful
      if ($user) {
        User_profile::create([
          'user_id' => $user->id,
          'first_name' => ucfirst($validated["first_name"]),
          'last_name' => ucfirst($validated["last_name"]),
        ]);

        // Create an API token
        $token = $user->createToken('API Token')->plainTextToken;

        $user->refresh(); // Reload the model to get the default values (e.g., pending status)

        DB::commit(); // Commit transaction

        // Return a success response with the token and user details
        return [
          "user" => new UserResource($user),
          "token" => $token
        ]; // Use resource to format the response
      }

      throw new Exception('User registration failed');
    } catch (Exception $e) {
      DB::rollBack(); // Rollback transaction on error
      return response()->json(['message' => 'User registration failed', 'error' => $e->getMessage()], 500);
    }
  }

  public function login(LoginUserRequest $request)
  {
    DB::beginTransaction(); // Start transaction

    try {
      // validate request
      $validated = $request->validated();
      $user = User::with("userprofile")->where("email", $validated["email"])->first();

      // check if email exists
      if (!$user || !Hash::check($validated["password"], $user->password)) {
        throw ValidationException::withMessages([
          'email' => ['The provided credentials are incorrect.'],
        ]);
      }

      // Create a new token
      $token = $user->createToken('API Token')->plainTextToken;

      // update login timestamp
      $user->update(["last_login_at" => now()]);
      
      DB::commit(); // Commit transaction

      return response()->json([
        'message' => 'Login successful',
        "user" => new UserResource($user),
        'token' => $token,
      ], 200);
    } catch (ValidationException $e) {
      DB::rollBack(); // Rollback transaction on validation error
      return response()->json(['errors' => $e->errors()], 401);
    } catch (Exception $e) {
      DB::rollBack(); // Rollback on any other errors
      return response()->json(['message' => 'Login failed', 'error' => $e->getMessage()], 500);
    }
  }

  public function logout(Request $request)
  {
    try {
      // Revoke all tokens for the user
      $request->user()->tokens()->delete();

      return response()->json([
        'message' => 'Logout successful'
      ], 200);
    } catch (Exception $e) {
      return response()->json(['message' => 'Logout failed', 'error' => $e->getMessage()], 500);
    }
  }
}
