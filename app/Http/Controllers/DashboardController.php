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
 

}
