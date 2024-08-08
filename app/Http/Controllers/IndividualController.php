<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Talent_profile;
use App\Models\User;
use App\Models\User_profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class IndividualController extends Controller
{
  public function index(User $user)
  {
    $user_profile = User_profile::where("user_id", $user->id)->first();
    $projects = Project::where("poster_id", $user->id)->get();

    foreach ($projects as $project) {
      Gate::authorize("view", $project);
    }

    return view("individual.dashboard", compact("user_profile", "projects", "user"));
  }

  private function getViewPath(string $view, string $userType): string
  {
    $prefix = $userType === 'company' ? 'company' : 'individual';
    return "{$prefix}.{$view}";
  }

  public function find_talents(User_profile $user_profile)
  {
    $talents = Talent_profile::with('userprofile')->get();
    
    return view($this->getViewPath('find_talent', auth()->user()->user_type), compact("user_profile", "talents"));
  }



  public function talent_search(Request $request)
  {
    $query = Talent_profile::with("userprofile");


    if (!empty($request->keyword)) {
      $query->where(function ($q) use ($request) {
        $q->orWhere('skills', 'like', '%' . $request->keyword . '%');
        $q->orWhere('education', 'like', '%' . $request->keyword . '%');
        $q->orWhere('experience', 'like', '%' . $request->keyword . '%');
      });
    }




    // Filtering by skills
    if ($request->filled('skills')) {
      $skills = $request->input('skills');
      $query->where(function ($q) use ($skills) {
        $q->where('skills', 'like', '%' . $skills . '%');
      });
    }

    // // Filtering by education
    // if ($request->filled('education')) {
    //   $skills = $request->input('skills');
    //   $query->where(function ($q) use ($skills) {
    //     $q->where('skills', 'like', '%' . $skills . '%');
    //   });
    // }


    // Filtering by location (assuming location is in user_profile table)
    if ($request->filled('location')) {
      $location = $request->input('location');
      $query->whereHas('userprofile', function ($q) use ($location) {
        $q->where('location', 'like', '%' . $location . '%');
      });
    }

    // Filtering by experience level
    if ($request->filled('experience')) {
      $experience = $request->input('experience');
      $query->where(function ($q) use ($experience) {
        $q->where('experience', 'like', '%' . $experience . '%');
      });
    }

    $talents = $query->paginate(4);
    
    return view('individual.find_talent', compact('talents'));
  }
}
