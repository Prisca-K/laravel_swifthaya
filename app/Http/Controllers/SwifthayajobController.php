<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompany_profileRequest;
use App\Http\Requests\StoreSwifthayajobRequest;
use App\Http\Requests\UpdateCompany_profileRequest;
use App\Http\Requests\UpdateSwifthayajobRequest;
use App\Models\Application;
use App\Models\Company_profile;
use App\Models\Project;
use App\Models\Swifthayajob;
use App\Models\Talent_profile;
use App\Models\User;
use App\Models\User_profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class SwifthayajobController extends Controller
{

  public function index()
  {
    $user = Auth::user();
    $jobs = Swifthayajob::where("company_id", $user->id)->get();
    // if (count($jobs) === 0) {
    //   return redirect()->route("job.create");
    // }
    foreach ($jobs as $job) {
      Gate::authorize("view", $job);
    }

    return view("company.jobs.job_posts", compact('user', "jobs"));
  }

  public function create()
  {
    $user = Auth::user();
    $company_profile = $user->userprofile->companyprofile;
    // dd($company_profile);
    if (is_null($company_profile)) {
      return redirect()->route("companies.create");
    }
    // check if company profile is approved
    if ($user->status !== "approved" || $company_profile->status !== "approved") {
      return redirect()->route("profile.edit")->with("error", "Your profile has not been approved");
    }
    return view("company.jobs.create_job", compact('user'));
  }

  public function store(StoreSwifthayajobRequest $request)
  {
    $user = Auth::user();

    $skillsArray = explode(',', request()->required_skills);
    $validated = $request->validated();
    $validated["company_id"] = $user->id;
    $validated["required_skills"] = json_encode($skillsArray);

    Swifthayajob::create($validated);
    return redirect()->route("jobs");
  }

  public function show(Swifthayajob $job)
  {
    Gate::authorize("view", $job);
    // dd($job);
    return view("company.jobs.view_job", compact("job"));
  }

  public function edit(Swifthayajob $job)
  {
    Gate::authorize("update", $job);
    $user = User::where("id", $job->company_id)->first();

    return view("company.jobs.edit_job", compact("job", "user"));
  }

  public function update(UpdateSwifthayajobRequest $request, Swifthayajob $job)
  {
    // dd($job);
    Gate::authorize("update", $job);
    $skillsArray = explode(',', request()->required_skills);
    $validated = $request->validated();
    $user = User::where("id", $job->company_id)->first();
    $validated["required_skills"] = json_encode($skillsArray);

    $job->update($validated);
    return redirect()->route("company.dashboard");
  }

  public function destroy(Swifthayajob $job)
  {
    Gate::authorize("delete", $job);
    $job->delete();
    return redirect()->route("jobs", Auth::user()->id);
  }

  // more details about job
  public function job_details(Swifthayajob $job)
  {
    $user_profile = User_profile::where("user_id", $job->company_id)->first();

    $company_profile = Company_profile::where("user_profile_id", $user_profile->id)->first();

    // dd($company_profile);
    // $job = $injob->with("companyprofile");
    return view("company.jobs.job_details", compact("job", "company_profile", "user_profile"));
  }

  // job offers
  public function offer_job(Talent_profile $talent_profile)
  {
    $user = Auth::user();
    // check if company profile is approved
    if ($user->user_type === "company") {
      if ($user->status !== "approved" || $user->userprofile->companyprofile->status !== "approved") {
        return redirect()->route("profile.edit")->with("error", "Your profile has not been approved");
      }
    } else {
      // check if individual is approved
      if ($user->status !== "approved") {
        return redirect()->route("profile.edit")->with("error", "Your profile has not been approved");
      }
    }
    $user_profile = User_profile::where("user_id", Auth::user()->id)->first();
    // $job = Swifthayajob::where("id", 8)->first();

    $jobs = Swifthayajob::where("company_id", Auth::user()->id)->get();
    $projects = Project::where("poster_id", Auth::user()->id)->get();

    if (count($projects) > 0) {
      $hasproject = true;
    } else $hasproject = false;
    // dd($projects);

    $candidate = $talent_profile;

    return view("company.jobs.job_offers", compact("jobs", "projects", "candidate", "hasproject"));
  }

  // view job applicants
  public function view_job_applicants(Swifthayajob $job)
  {

    Gate::authorize("update", $job);
    $applications = Application::where("swifthayajob_id", $job->id)->get();
    $isjob = true;
    return view("shared.view_applicants", compact("job", "applications", "isjob"));
  }
}
