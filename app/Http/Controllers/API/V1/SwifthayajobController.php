<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSwifthayajobRequest;
use App\Http\Requests\UpdateSwifthayajobRequest;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\SwifthayajobResource;
use App\Models\Application;
use App\Models\Swifthayajob;
use App\Models\Talent_profile;
use App\Models\User;
use App\Models\User_profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Exception;

class SwifthayajobController extends Controller
{
  public function index()
  {
    try {
      $user = Auth::user();

      $jobs = Swifthayajob::where("company_id", $user->id)->get();
      if (!$jobs) {
        return response()->json(["message" => "Company has no Jobs"]);
      }
      foreach ($jobs as $job) {
        Gate::authorize("view", $job);
      }

      return SwifthayajobResource::collection($jobs);
    } catch (Exception $e) {
      DB::rollBack(); // Rollback in case of failure
      return response()->json(['message' => 'Failed to retrieve jobs', 'error' => $e->getMessage()], 500);
    }
  }

  public function show(Swifthayajob $job)
  {
    try {
      Gate::authorize("view", $job);
      return new SwifthayajobResource($job);
    } catch (Exception $e) {
      DB::rollBack(); // Rollback in case of failure
      return response()->json(['message' => 'Failed to retrieve job', 'error' => $e->getMessage()], 500);
    }
  }


  public function store(StoreSwifthayajobRequest $request)
  {
    DB::beginTransaction(); // Begin DB transaction

    try {
      $user = Auth::user();

      $validated = $request->validated();
      $skillsArray = explode(',', $validated["skills"]);

      $validated["company_id"] = Auth::user()->id;
      $validated["required_skills"] = json_encode($skillsArray);

      $job = $user->swifthayajob()->create($validated);

      $job->refresh(); // Reload the model to get the default values (e.g., pending status)
      DB::commit(); // Commit transaction
      return ["message" => "Job created successfully", "data" => new SwifthayajobResource($job)];
    } catch (Exception $e) {
      DB::rollBack(); // Rollback in case of failure
      return response()->json(['message' => 'Failed to create job', 'error' => $e->getMessage()], 500);
    }
  }

  public function update(UpdateSwifthayajobRequest $request, Swifthayajob $job)
  {
    DB::beginTransaction(); // Begin DB transaction

    try {
      Gate::authorize("update", $job);

      $validated = $request->validated();
      $skillsArray = explode(',', $validated["skills"]);
      $validated["required_skills"] = json_encode($skillsArray);

      $job->update($validated);

      DB::commit(); // Commit transaction

      return ["message" => "Job created successfully", "data" => new SwifthayajobResource($job)];
    } catch (Exception $e) {
      DB::rollBack(); // Rollback in case of failure
      return response()->json(['message' => 'Failed to update job', 'error' => $e->getMessage()], 500);
    }
  }

  public function destroy(Swifthayajob $job)
  {
    DB::beginTransaction(); // Begin DB transaction

    try {
      Gate::authorize("delete", $job);
      $job->delete();

      DB::commit(); // Commit transaction

      return response()->json(["message" => "Job deleted successfully"]);
    } catch (Exception $e) {
      DB::rollBack(); // Rollback in case of failure
      return response()->json(['message' => 'Failed to delete job', 'error' => $e->getMessage()], 500);
    }
  }

  public function offer_job()
  {
    // This should return job offer from database
    // Example: offers where employer_id = 1
  }

  public function job_search(Request $request)
  {
    try {
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
        $query->where('title', 'like', '%' . $request->title . '%');
      }

      // Filtering by required_skills
      if ($request->filled('required_skills')) {
        $query->where('required_skills', 'like', '%' . $request->required_skills . '%');
      }

      // Filtering by salary_range
      if ($request->filled('salary_range')) {
        $query->where('salary_range', 'like', '%' . $request->salary_range . '%');
      }

      // Filtering by location
      if ($request->filled('location')) {
        $query->where('location', 'like', '%' . $request->location . '%');
      }

      // Filtering by job_type
      if ($request->filled('job_type')) {
        $query->where('job_type', 'like', '%' . $request->job_type . '%');
      }

      $jobs = $query->latest()->paginate(10);

      return SwifthayajobResource::collection($jobs);
    } catch (Exception $e) {
      return response()->json(['message' => 'Failed to search for jobs', 'error' => $e->getMessage()], 500);
    }
  }
}
