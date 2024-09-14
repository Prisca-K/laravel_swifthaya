<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\User;
use App\Models\User_profile;
use Illuminate\Http\Request;
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

    if (count($projects) === 0) {
      return redirect()->route("project.create", $user->id);
    }
    foreach ($projects as $project) {
      Gate::authorize("view", $project);
    }
    return view('projects.project_posts', compact("user", "projects"));
  }

  public function create(User $user)
  {
    return view('projects.create_project', compact("user"));
  }

  public function store(StoreProjectRequest $request, User $user)
  {
    // validation rules
    $validated = $request->validated();
    $validated["poster_id"] = $user->id;
    Project::create($validated);
    return redirect()->route("projects", $user->id);
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
    $validated = $request->validated();
    $user = User::where("id", $project->poster_id)->first();
    // dd($user);

    $validated["poster_id"] = $user->id;
    $project->update($validated);

    return redirect()->route("projects", $user->id);
  }
  public function destroy(Project $project)
  {
    Gate::authorize("delete", $project);
    $project->delete();
    return redirect()->route("projects", auth()->id());
  }
  public function project_details(Project $project)
  {
    $user_profile = User_profile::where("user_id", $project->poster_id)->first();

    // $company_profile = Company_profile::where("user_profile_id", $user_profile->id)->first();


    // dd($company_profile);
    // $job = $injob->with("companyprofile");
    return view("projects.project_details", compact("project", "user_profile"));
  }
}
