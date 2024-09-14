<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
  /**
   * Display the login view.
   */
  public function create(): View
  {
    return view('auth.login');
  }

  /**
   * Handle an incoming authentication request.
   */
  public function store(LoginRequest $request): RedirectResponse
  {
    // dd($request);
    $request->authenticate();

    $request->session()->regenerate();
    // dd(Auth::user()->user_type);


    if (Auth::user()->user_type === "company") {
      return redirect(route('company.dashboard'));
    } elseif (Auth::user()->user_type === "individual") {
      return redirect(route('individual.dashboard'));
    } elseif (Auth::user()->user_type === "talent") {
      return redirect(route('talent.dashboard'));
    } elseif (Auth::user()->user_type === "admin") {
      return redirect(route('admin.dashboard'));
    }
  }

  /**
   * Destroy an authenticated session.
   */
  public function destroy(Request $request): RedirectResponse
  {
    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/');
  }
}
