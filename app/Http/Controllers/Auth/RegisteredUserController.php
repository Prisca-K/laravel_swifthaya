<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User_profile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
  /**
   * Display the registration view.
   */
  public function create(): View
  {
    return view('auth.register');
  }

  /**
   * Handle an incoming registration request.
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function store(Request $request): RedirectResponse
  {


    $validated = $request->validate([
      'first_name' => ['required', 'string', 'min:3', 'max:20'],
      'last_name' => ['required', 'string', 'min:3', 'max:20'],
      'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
      'password' => ['required', 'confirmed', Rules\Password::defaults()],
      'user_type' => ['required', 'in:talent,company,individual'],

    ]);

    $user = User::create([
      'email' => $validated["email"],
      'password' => Hash::make($validated["password"]),
      'user_type' => $validated["user_type"],
    ]);

    // creating user profile
    if ($user) {
      User_profile::create([
        'user_id' => $user->id,
        'first_name' => ucfirst($validated["first_name"]),
        'last_name' => ucfirst($validated["last_name"]),
      ]);
    }

    event(new Registered($user));

    Auth::login($user);

    if ($user->user_type === "company") {
      return redirect(route('company.dashboard', $user->id));
    } elseif ($user->user_type === "individual") {
      return redirect(route('individual.dashboard', $user->id));
    } elseif ($user->user_type === "talent") {
      return redirect(route('talent.dashboard', $user->id));
    } else return redirect(route('dashboard', $user->id));
  }
}
