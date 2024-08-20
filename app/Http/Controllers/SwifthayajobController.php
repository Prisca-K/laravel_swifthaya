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
use PhpParser\Node\Stmt\Switch_;

use function PHPUnit\Framework\isEmpty;

class SwifthayajobController extends Controller
{

  public function index(User $user)
  {
    $jobs = Swifthayajob::where("company_id", $user->id)->get();
    if (count($jobs) === 0) {
      return redirect()->route("job.create", $user->id);
    }
    foreach ($jobs as $job) {
      Gate::authorize("view", $job);
    }

    return view("company.jobs.job_posts", compact('user', "jobs"));
  }

  public function create(User $user)
  {
    $hascompanyprofile = Company_profile::where("user_profile_id", $user->userprofile->id)->exists();
    // dd($hascompanyprofile);
    if (!$hascompanyprofile) {
      return redirect()->route("profile.edit", Auth::user()->id);
    }
    return view("company.jobs.create_job", compact('user'));
  }

  public function store(StoreSwifthayajobRequest $request, User $user)
  {
    $validated = $request->validated();
    $validated["company_id"] = $user->id;

    Swifthayajob::create($validated);
    return redirect()->route("jobs", $user->id);
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
    $validated = $request->validated();
    $user = User::where("id", $job->company_id)->first();
    $validated["company_id"] = $user->id;
    $job->update($validated);
    return redirect()->route("company.dashboard", $user->id);
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

    $user_profile = User_profile::where("user_id", Auth::user()->id)->first();
    // $job = Swifthayajob::where("id", 8)->first();

    $jobs = Swifthayajob::where("company_id", Auth::user()->id)->get();
    $projects = Project::where("poster_id", Auth::user()->id)->get();

    if (count($projects) > 0) {
      $hasproject = true;
    } else $hasproject = false;
    // dd($projects);
    // $company_profile = Company_profile::where("user_profile_id", $user_profile->id)->first();

    $candidate = $talent_profile;

    return view("company.jobs.job_offers", compact("jobs", "projects", "candidate", "hasproject"));
  }

  // view job appliccants
  public function view_job_applicants(Swifthayajob $job)
  {

    Gate::authorize("update", $job);
    $applications = Application::where("swifthayajob_id", $job->id)->get();
    $isjob = true;
    return view("view_applicants", compact("job", "applications", "isjob"));
  }
  public function view_project_applicants(Project $project)
  {

    Gate::authorize("update", $project);
    $applications = Application::where("project_id", $project->id)->get();
    $isjob = false;
    return view("view_applicants", compact("project", "applications", "isjob"));
  }
}
