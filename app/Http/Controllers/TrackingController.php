<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\SwifthayajobResource;
use App\Models\Application;
use App\Models\Project;
use App\Models\Swifthayajob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class TrackingController extends Controller
{
  // jobs that are ready to be tracked
  public function pendingJob($user_id)
  {
    DB::beginTransaction(); // Start the transaction
    try {
      // Fetch jobs or projects based on the user's role or selection
      $status = "accepted";
      $jobs = Swifthayajob::where(["company_id", $user_id])->whereHas('application', function ($subQuery) use ($status) {
        $subQuery->where(["status" => $status]);
      })->get();

      DB::commit(); // Commit the transaction
      return SwifthayajobResource::collection($jobs);
    } catch (Exception $e) {
      DB::rollBack(); // Rollback the transaction if there’s an error
      return response()->json(['message' => 'Error fetching pending jobs', 'error' => $e->getMessage()], 500);
    }
  }

  public function startJob(Swifthayajob $job)
  {
    DB::beginTransaction();
    try {
      if ($job->application()->first()->status !== "accepted") {
        return [
          "message" => "Can't start Job where application is unaccepted by the employer",
        ];
      }

      $job = Swifthayajob::where("id", $job->id);
      $status = 'in_progress';
      $job->update(["tracking_status" => $status]);

      DB::commit();
      return [
        "message" => "Tracking status updated to In-progress",
        "data" => new SwifthayajobResource($job)
      ];
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['message' => 'Error starting job', 'error' => $e->getMessage()], 500);
    }
  }

  public function completeJob(Swifthayajob $job)
  {
    DB::beginTransaction();
    try {
      $job = Swifthayajob::where("id", $job->id);
      $status = 'completed';
      $job->update(["tracking_status" => $status]);

      DB::commit();
      return [
        "message" => "Tracking status updated to Completed",
        "data" => new SwifthayajobResource($job)
      ];
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['message' => 'Error completing job', 'error' => $e->getMessage()], 500);
    }
  }

  // Projects
  public function pendingProject($user_id)
  {
    DB::beginTransaction();
    try {
      $status = "pending";
      $projects = Project::where(["poster_id", $user_id])->whereHas('application', function ($subQuery) use ($status) {
        $subQuery->where(["status" => $status]);
      })->get();

      DB::commit();
      return ProjectResource::collection($projects);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['message' => 'Error fetching pending projects', 'error' => $e->getMessage()], 500);
    }
  }

  public function startProject(Project $project)
  {
    DB::beginTransaction();
    try {
      if ($project->application()->first()->status !== "accepted") {
        return [
          "message" => "Can't start Project where application is unaccepted by the employer",
        ];
      }

      $project = Project::where("id", $project->id);
      $status = 'in_progress';
      $project->update(["tracking_status" => $status]);

      DB::commit();
      return [
        "message" => "Tracking status updated to In-progress",
        "data" => new ProjectResource($project)
      ];
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['message' => 'Error starting project', 'error' => $e->getMessage()], 500);
    }
  }

  public function completeProject(Project $project)
  {
    DB::beginTransaction();
    try {
      $project = Project::where("id", $project->id);
      $status = 'completed';
      $project->update(["tracking_status" => $status]);

      DB::commit();
      return [
        "message" => "Tracking status updated to Completed",
        "data" => new ProjectResource($project)
      ];
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['message' => 'Error completing project', 'error' => $e->getMessage()], 500);
    }
  }
}
