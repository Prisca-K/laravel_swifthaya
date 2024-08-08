<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTalent_profileRequest;
use App\Http\Requests\UpdateTalent_profileRequest;
use App\Models\Project;
use App\Models\Swifthayajob;
use App\Models\Talent_profile;
use App\Models\User;
use App\Models\User_profile;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use function PHPUnit\Framework\isNull;

class Talent_ProfileController extends Controller
{

  public function index(User $user)
  {
    if ($user->id !== auth()->id()) {
      abort("403");
    }

    $user_profile = User_profile::where("user_id", $user->id)->first();
    $talent_profile = Talent_profile::where("user_profile_id", $user_profile->id)->first();
    // boolval($user_profile->talentprofile)
    return view("talent.dashboard", compact("user_profile", "talent_profile"));
  }

  public function create(User_profile $user_profile)
  {
    $talent_profile = Talent_profile::where("user_profile_id", $user_profile->id)->first();
    if (!is_null($talent_profile)) {
      Gate::authorize("view", $talent_profile);
      return view("talent.view_profile", compact("user_profile", "talent_profile"));
    }
    return view("talent.create_profile", compact("user_profile"));
  }

  public function store(StoreTalent_profileRequest $request, User_profile $user_profile)
  {
    if ($user_profile->user_id !== auth()->id()) {
      abort("403");
    }
    $validated = $request->validated();

    $has_talent_profile = Talent_profile::where("user_profile_id", $user_profile->id)->first();
    if ($has_talent_profile) {
      Gate::authorize("update", $has_talent_profile);
    }
    if (!$has_talent_profile) {

      $talent_profile = Talent_profile::create(
        [
          'user_profile_id' => $user_profile->id,
          'skills' => $validated["skills"],
          'experience' => $validated["experience"],
          'education' => $validated["education"],
          'portfolio' => $validated["portfolio"],
        ]
      );
      return redirect()->route('talent.show', [$user_profile->id])->with('success', 'Talent profile created successfully.');
    }

    $talent_profile = $has_talent_profile;
    return view("talent.view_profile", compact("user_profile", "talent_profile"));
  }

  public function show(User_profile $user_profile)
  {
    $talent_profile = Talent_profile::where("user_profile_id", $user_profile->id)->first();
    Gate::authorize("view", $talent_profile);
    return view("talent.view_profile", compact("user_profile", "talent_profile"));
  }

  public function edit(Talent_profile $talent_profile)
  {
    $user_profile = User_profile::where("id", $talent_profile->user_profile_id)->first();
    // dd($user_profile->id);

    Gate::authorize("update", $talent_profile);

    return view("talent.edit_profile", compact("talent_profile", "user_profile"));
  }

  public function update(UpdateTalent_profileRequest $request, Talent_profile $talent_profile)
  {
    Gate::authorize("update", $talent_profile);
    // validation rules
    $user_profile = User_profile::where("id", $talent_profile->user_profile_id)->first();
    $validated = $request->validated();

    $talent_profile->update(
      [
        'user_profile_id' => $user_profile->id,
        'skills' => $validated["skills"],
        'experience' => $validated["experience"],
        'education' => $validated["education"],
        'portfolio' => $validated["portfolio"],
      ]
    );

    return redirect()->route('talent.show', [$user_profile->id])->with('success', 'Talent profile created successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Talent_profile $talent_profile)
  {
    Gate::authorize("delete", $talent_profile);
    $talent_profile->delete();
    return redirect()->route("talent.dashboard", auth()->id());
  }

  public function find_jobs()
  {
    $jobs = Swifthayajob::with('companyprofile')->get();
    return view("talent.find_jobs", compact("jobs"));
  }

  public function job_search(Request $request)
  {
    $query = Swifthayajob::with("companyprofile");


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

    // // Filtering by education
    // if ($request->filled('education')) {
    //   $skills = $request->input('skills');
    //   $query->where(function ($q) use ($skills) {
    //     $q->where('skills', 'like', '%' . $skills . '%');
    //   });
    // }


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

    $jobs = $query->paginate(10);

    return view('talent.find_jobs', compact('jobs'));
  }
  public function find_projects()
  {
    $projects = Project::with('user')->get();
    return view("talent.find_projects", compact("projects"));
  }

  public function project_search(Request $request)
  {
    $query = Project::with("user");


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

    // // Filtering by education
    // if ($request->filled('education')) {
    //   $skills = $request->input('skills');
    //   $query->where(function ($q) use ($skills) {
    //     $q->where('skills', 'like', '%' . $skills . '%');
    //   });
    // }


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

    $projects = $query->paginate(10);

    return view('talent.find_projects', compact('projects'));
  }
}
