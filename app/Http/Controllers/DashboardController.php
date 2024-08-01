<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_profile;
use Illuminate\Http\Request;
use Psy\Readline\Userland;

class DashboardController extends Controller
{
  public function index()
  {

    return view("dashboard");
  }
  public function talent(User_profile $user_profile)
  {

    return view("talent.dashboard", compact("user_profile"));
  }
  public function company(User_profile $user_profile)
  {

    return view("company.dashboard", compact("user_profile"));
  }
  public function individual(User_profile $user_profile)
  {

    return view("individual.dashboard", compact("user_profile"));
  }
}
