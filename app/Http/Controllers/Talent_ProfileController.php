<?php

namespace App\Http\Controllers;


use App\Models\Project;
use App\Models\Swifthayajob;
use App\Models\Talent_profile;
use App\Models\User;
use App\Models\User_profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Talent_ProfileController extends Controller
{

  public function index()
  {

    $user_profile = User_profile::where("user_id", Auth::user()->id)->first();
    $talent_profile = Talent_profile::where("user_profile_id", $user_profile->id)->first();

    // boolval($user_profile->talentprofile)
    return view("talent.dashboard", compact("user_profile", "talent_profile"));
  }

  public function create()
  {
    $user_profile = Auth::user()->userprofile;
    $talent_profile = Talent_profile::where("user_profile_id", $user_profile->id)->first();
    if (!is_null($talent_profile)) {
      Gate::authorize("view", $talent_profile);
      return view("talent.view_profile", compact("user_profile", "talent_profile"));
    }
    // dd("hello");
    return view("talent.create_profile", compact("user_profile"));
  }

  public function store()
  {
    $user_profile = Auth::user()->userprofile;
    $has_talent_profile = Talent_profile::where("user_profile_id", $user_profile->id)->first();

    if (!is_null($has_talent_profile)) {
      // else ie if has_talent_profile is not null
      Gate::authorize("update", $has_talent_profile);

      return redirect()->route("talent.show", $has_talent_profile->id);
    }

    $skillsArray = explode(',', request()->skills);
    $experienceArray = request()->experience;
    $educationArray = request()->education;
    $portfolioArray = request()->portfolio;
    // dd(json_encode($experienceArray), json_encode($skillsArray));
    // dd(json_encode($experienceArray));

    $talent_profile = Talent_profile::create(
      [
        'user_profile_id' => $user_profile->id,
        'skills' => json_encode($skillsArray),
        'experience' => json_encode($experienceArray),
        'education' => json_encode($educationArray),
        'portfolio' => json_encode($portfolioArray)
      ]
    );
    return redirect()->route('talent.show', [$talent_profile->id])->with('success', 'Talent profile created successfully.');
  }

  public function show()
  {
    $talent_profile = Auth::user()->userprofile->talentprofile;
    // dd($talent_profile);
    Gate::authorize("view", $talent_profile);
    // dd(json_decode($talent_profile->experience, true));
    // $education = json_decode($talent_profile->education, true);
    return view("talent.view_profile", compact("talent_profile"));
  }

  public function edit(Talent_profile $talent_profile)
  {
    Gate::authorize("update", $talent_profile);
    $user_profile = User_profile::where("id", $talent_profile->user_profile_id)->first();
    // dd(json_decode($talent_profile->education, true));
    return view("talent.edit_profile", compact("talent_profile", "user_profile"));
  }

  public function update(Talent_profile $talent_profile)
  {
    Gate::authorize("update", $talent_profile);
    // validation rules

    $skillsArray = explode(',', request()->skills);
    $experienceArray = request()->experience;
    $educationArray = request()->education;
    $portfolioArray = request()->portfolio;
    // dd(json_encode($experienceArray), json_encode($skillsArray));
    // dd(json_encode($educationArray));


    $talent_profile->update(
      [
        'skills' => json_encode($skillsArray),
        'experience' => json_encode($experienceArray),
        'education' => json_encode($educationArray),
        'portfolio' => json_encode($portfolioArray)
      ]
    );
    return redirect()->route('talent.show')->with('success', 'Talent profile created successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  // public function destroy(Talent_profile $talent_profile)
  // {
  //   Gate::authorize("delete", $talent_profile);
  //   $talent_profile->delete();
  //   return redirect()->route("talent.dashboard", Auth::user()->id);
  // }


  public function talent_details(Talent_profile $talent_profile)
  {
    return view("talent.talent_details", compact("talent_profile"));
  }

  public function job_search(Request $request)
  {
    $query = Swifthayajob::with("user")->where('status', "approved");


    if (!empty($request->keyword)) {
      $query->where(function ($q) use ($request) {
        $q->orWhere('title', 'like', '%' . $request->keyword . '%');
        $q->orWhere('required_skills', 'like', '%' . $request->keyword . '%');
        $q->orWhere('location', 'like', '%' . $request->keyword . '%');
        $q->orWhere('job_type', 'like', '%' . $request->keyword . '%');
      });
    }


    // Filtering by title
    if ($request->filled('title')) {
      $title = $request->input('title');
      $query->where(function ($q) use ($title) {
        $q->where('title', 'like', '%' . $title . '%');
      });
    }
    // Filtering by required_skills
    if ($request->filled('required_skills')) {
      $required_skills = $request->input('required_skills');
      $query->where(function ($q) use ($required_skills) {
        $q->where('required_skills', 'like', '%' . $required_skills . '%');
      });
    }
    // Filtering by salary_range
    if ($request->filled('salary_range')) {
      $salary_range = $request->input('salary_range');
      $query->where(function ($q) use ($salary_range) {
        $q->where('salary_range', 'like', '%' . $salary_range . '%');
      });
    }



    // Filtering by location (location is in user_profile table)
    if ($request->filled('location')) {
      $location = $request->input('location');
      $query->where(function ($q) use ($location) {
        $q->where('location', 'like', '%' . $location . '%');
      });
    }

    // Filtering by job_type level
    if ($request->filled('job_type')) {
      $job_type = $request->input('job_type');
      $query->where(function ($q) use ($job_type) {
        $q->where('job_type', 'like', '%' . $job_type . '%');
      });
    }

    $jobs = $query->latest()->paginate(4);

    return view('talent.find_jobs', compact('jobs'));
  }

  public function project_search(Request $request)
  {
    $query = Project::with("user")->where('status', "approved");


    if (!empty($request->keyword)) {
      $query->where(function ($q) use ($request) {
        $q->orWhere('title', 'like', '%' . $request->keyword . '%');
        $q->orWhere('required_skills', 'like', '%' . $request->keyword . '%');
        $q->orWhere('duration', 'like', '%' . $request->keyword . '%');
        $q->orWhere('budget', 'like', '%' . $request->keyword . '%');
      });
    }

    // Filtering by title
    if ($request->filled('title')) {
      $title = $request->input('title');
      $query->where(function ($q) use ($title) {
        $q->where('title', 'like', '%' . $title . '%');
      });
    }
    // Filtering by required_skills
    if ($request->filled('required_skills')) {
      $required_skills = $request->input('required_skills');
      $query->where(function ($q) use ($required_skills) {
        $q->where('required_skills', 'like', '%' . $required_skills . '%');
      });
    }


    // Filtering by duration
    if ($request->filled('duration')) {
      $duration = $request->input('duration');
      $query->where(function ($q) use ($duration) {
        $q->where('duration', 'like', '%' . $duration . '%');
      });
    }

    // Filtering by budget
    if ($request->filled('budget')) {
      $budget = $request->input('budget');
      $query->where(function ($q) use ($budget) {
        $q->where('budget', 'like', '%' . $budget . '%');
      });
    }

    $projects = $query->latest()->paginate(4);

    return view('talent.find_projects', compact('projects'));
  }
}
