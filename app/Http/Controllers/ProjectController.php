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
    return view($this->getViewPath('projects.project_posts', $user->user_type), compact("user", "projects"));
  }

  public function create(User $user)
  {
    return view($this->getViewPath('projects.create_project', $user->user_type), compact("user"));
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

    return view($this->getViewPath('projects.view_project', auth()->user()->user_type), compact("project"));
  }
  public function edit(Project $project)
  {

    Gate::authorize("update", $project);
    $user = User::where("id", $project->poster_id)->first();
    return view($this->getViewPath('projects.edit_project', $user->user_type), compact("user", "project"));
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
}
