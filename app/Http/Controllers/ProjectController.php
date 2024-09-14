<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Application;
use App\Models\Company_profile;
use App\Models\Project;
use App\Models\User;
use App\Models\User_profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{

  private function getViewPath(string $view, string $userType): string
  {
    $prefix = $userType === 'company' ? 'company' : 'individual';
    return "{$prefix}.{$view}";
  }
  public function index(User $user)
  {
    $projects = Project::where("poster_id", $user->id)->get();

    foreach ($projects as $project) {
      Gate::authorize("view", $project);
    }
    return view('projects.project_posts', compact("user", "projects"));
  }

  public function create(User $user)
  {
    $user = Auth::user();
    $company_profile = Company_profile::where("user_profile_id", $user->userprofile->id)->first();
    
    // check if company profile is approved
    if (Auth::user()->user_type === "company") {
      if ($user->status !== "approved" || $company_profile->status !== "approved") {
        return redirect()->route("profile.edit")->with("error", "Your profile has not been approved");
      }
    } else{
      // check if individual is approved
      if ($user->status !== "approved") {
        return redirect()->route("profile.edit")->with("error", "Your profile has not been approved");
      }
    }
    return view('projects.create_project', compact("user"));
  }

  public function store(StoreProjectRequest $request)
  {
    $skillsArray = explode(',', request()->required_skills);
    // validation rules
    $validated = $request->validated();
    $validated["poster_id"] = Auth::user()->id;
    $validated["required_skills"] = json_encode($skillsArray);
    $project = Project::create($validated);

    return redirect()->route("project.show", $project->id);
  }

  public function show(Project $project)
  {
    Gate::authorize("view", $project);

    return view('projects.view_project', compact("project"));
  }
  public function edit(Project $project)
  {

    Gate::authorize("update", $project);
    $user = User::where("id", $project->poster_id)->first();
    return view('projects.edit_project', compact("user", "project"));
  }
  public function update(UpdateProjectRequest $request, Project $project)
  {
    Gate::authorize("update", $project);
    $skillsArray = explode(',', request()->required_skills);
    $validated = $request->validated();
    $user = User::where("id", $project->poster_id)->first();
    // dd($user);

    $validated["required_skills"] = json_encode($skillsArray);
    $project->update($validated);

    return redirect()->route("projects", $user->id);
  }
  public function destroy(Project $project)
  {
    Gate::authorize("delete", $project);
    $project->delete();
    return redirect()->route("projects", Auth::user()->id);
  }
  public function project_details(Project $project)
  {
    $user_profile = User_profile::where("user_id", $project->poster_id)->first();

    return view("projects.project_details", compact("project", "user_profile"));
  }
  public function view_project_applicants(Project $project)
  {
    Gate::authorize("update", $project);
    $applications = Application::where("project_id", $project->id)->get();
    $isjob = false;
    return view("shared.view_applicants", compact("project", "applications", "isjob"));
  }
}
