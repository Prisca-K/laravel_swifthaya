<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Exception;

class ProjectController extends Controller
{
  public function index()
  {

    try {
      $user = Auth::user();

      $projects = Project::where("poster_id", $user->id)->get();
      foreach ($projects as $project) {
        Gate::authorize("view", $project);
      }

      return ProjectResource::collection($projects);
    } catch (Exception $e) {
      return response()->json(['message' => 'Failed to retrieve projects', 'error' => $e->getMessage()], 500);
    }
  }

  public function show(Project $project)
  {
    try {
      Gate::authorize("view", $project);
      return new ProjectResource($project);
    } catch (Exception $e) {
      return response()->json(['messsage' => 'Failed to retrieve project', 'error' => $e->getMessage()], 500);
    }
  }

  public function store(StoreProjectRequest $request)
  {
    DB::beginTransaction(); // Begin DB transaction

    try {
      $user = Auth::user();

      $validated = $request->validated();
      $skillsArray = explode(',', $validated["skills"]);
      $validated["poster_id"] = Auth::user()->id;
      $validated["required_skills"] = json_encode($skillsArray);

      $project = $user->project()->create($validated);

      $project->refresh(); // Reload the model to get the default values (e.g., pending status)
      DB::commit(); // Commit transaction

      return ["message" => "Project created successfully", "data" => new ProjectResource($project)];
    } catch (Exception $e) {
      DB::rollBack(); // Rollback in case of failure
      return response()->json(['message' => 'Failed to create project', 'error' => $e->getMessage()], 500);
    }
  }

  public function update(UpdateProjectRequest $request, Project $project)
  {
    DB::beginTransaction(); // Begin DB transaction

    try {
      Gate::authorize("update", $project);

      $validated = $request->validated();
      $skillsArray = explode(',', $validated["skills"]);
      $validated["required_skills"] = json_encode($skillsArray);

      $project->update($validated);

      DB::commit(); // Commit transaction

      return [
        "message" => "Project updated successfully",
        "data" => new ProjectResource($project)
      ];
    } catch (Exception $e) {
      DB::rollBack(); // Rollback in case of failure
      return response()->json(['message' => 'Failed to update project', 'error' => $e->getMessage()], 500);
    }
  }

  public function destroy(Project $project)
  {
    DB::beginTransaction(); // Begin DB transaction

    try {
      Gate::authorize("delete", $project);
      $project->delete();

      DB::commit(); // Commit transaction

      return response()->json(["message" => "Project deleted successfully"]);
    } catch (Exception $e) {
      DB::rollBack(); // Rollback in case of failure
      return response()->json(['message' => 'Failed to delete project', 'error' => $e->getMessage()], 500);
    }
  }

  public function project_search(Request $request)
  {
    try {
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

      $projects = $query->latest()->paginate(10);

      return ProjectResource::collection($projects);
    } catch (Exception $e) {
      return response()->json(['message' => 'Failed to search for projects', 'error' => $e->getMessage()], 500);
    }
  }
}
