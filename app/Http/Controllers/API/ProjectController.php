<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
  public function index()
  {
    $user = Auth::user();

    $projects = Project::where("poster_id", $user->id)->get();
    foreach ($projects as $project) {
      Gate::authorize("view", $project);
    }

    return ProjectResource::collection($projects);
  }

  public function store(StoreProjectRequest $request)
  {
    $user = Auth::user();

    $skillsArray = explode(',', request()->required_skills);
    $validated = $request->validated();

    $validated["poster_id"] = Auth::user()->id;
    $validated["required_skills"] = json_encode($skillsArray);

    $project = $user->project()->create($validated);
    return new ProjectResource($project);
  }

  public function show(Project $project)
  {
    Gate::authorize("view", $project);
    return new ProjectResource($project);
  }

  public function update(UpdateProjectRequest $request, Project $project)
  {
    // dd($project);
    Gate::authorize("update", $project);
    $skillsArray = explode(',', request()->required_skills);

    $validated = $request->validated();

    $validated["required_skills"] = json_encode($skillsArray);

    $project->update($validated);
    return new ProjectResource($project);
  }

  public function destroy(Project $project)
  {
    Gate::authorize("delete", $project);
    $project->delete();
    return response()->json(["message" => "Project deleted successfully"]);
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
