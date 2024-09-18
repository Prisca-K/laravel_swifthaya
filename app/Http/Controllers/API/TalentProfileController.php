<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TalentProfileResource;
use App\Models\Project;
use App\Models\Swifthayajob;
use App\Models\Talent_profile;
use App\Models\User_profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TalentProfileController extends Controller
{
  public function show()
  {
    $talent_profile = Auth::user()->userprofile->talentprofile;
    // dd($talent_profile);
    Gate::authorize("view", $talent_profile);;

    return new TalentProfileResource($talent_profile);
  }

  public function store(Request $request)
  {
    $user_profile = Auth::user()->userprofile;

    $has_talent_profile = Talent_profile::where("user_profile_id", $user_profile->id)->first();

    if (!is_null($has_talent_profile)) {
      // else ie if has_talent_profile is not null
      Gate::authorize("update", $has_talent_profile);

      return [
        'message' => "User already has a talent profile",
        new TalentProfileResource($has_talent_profile)
      ];
    }

    $skillsArray = explode(',', $request->skills);
    $experienceArray = $request->experience;
    $educationArray = $request->education;
    $portfolioArray = $request->portfolio;
    // dd(json_encode($experienceArray), json_encode($skillsArray));
    // dd(json_encode($experienceArray));

    $talent_profile = $user_profile->talentprofile()->create(
      [
        'user_profile_id' => $user_profile->id,
        'skills' => json_encode($skillsArray),
        'experience' => json_encode($experienceArray),
        'education' => json_encode($educationArray),
        'portfolio' => json_encode($portfolioArray)
      ]
    );

    // Use resource to format the response
    return new TalentProfileResource($talent_profile);
  }

  public function update(Request $request, Talent_profile $talent_profile)
  {
    Gate::authorize("update", $talent_profile);
    // validation rules

    $skillsArray = explode(',', $request->skills);
    $experienceArray = $request->experience;
    $educationArray = $request->education;
    $portfolioArray = $request->portfolio;
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
    return new TalentProfileResource($talent_profile);
  }

  public function destroy(Talent_profile $talent_profile)
  {
    Gate::authorize("delete", $talent_profile);
    $talent_profile->delete();
    return response()->json([
      "message"  => "Talent Profile deleted sucessfully"
    ]);
  }

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
