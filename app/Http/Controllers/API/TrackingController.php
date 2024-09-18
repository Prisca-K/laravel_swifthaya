<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\SwifthayajobResource;
use App\Models\Application;
use App\Models\Project;
use App\Models\Swifthayajob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
  public function pendingJob()
  {
    // Fetch jobs or projects based on the user's role or selection
    // $applications = Application::where(["applicant_id" => Auth::user()->id, "status" => "accepted"])->get();
    $applicant_id = 61;
    $status = "pending";
    $applications = Application::where(["applicant_id" => $applicant_id, "status" => "accepted"])->whereHas('swifthayajob', function ($subQuery) use ($status) {
      $subQuery->where('tracking_status', $status);
    })->get();


    return ApplicationResource::collection($applications);
  }

  public function startJob(Swifthayajob $job)
  {

    if ($job->application()->first()->status !== "accepted") {
      return [
        "message" => "Can't start Job where application is unaccepted by the employer",
      ];
    }

    $job = Swifthayajob::where("id", $job->id);
    $status = 'in_progress';
    $job->update(["tracking_status" => $status]);


    return [
      "message" => "Tracking status updated to In-progress",
      "data" => new SwifthayajobResource($job)
    ];
  }
  public function completeJob(Swifthayajob $job)
  {
    $job = Swifthayajob::where("id", $job->id);
    $status = 'completed';
    $job->update(["tracking_status" => $status]);
    return [
      "message" => "Tracking status updated to In-progress",
      "data" => new SwifthayajobResource($job)
    ];
  }

  // Projects
  public function pendingProject()
  {
  
    $applicant_id = 61;
    $status = "pending";
    $applications = Application::where(["applicant_id" => $applicant_id, "status" => "accepted"])->whereHas('project', function ($subQuery) use ($status) {
      $subQuery->where('tracking_status', $status);
    })->get();


    return ApplicationResource::collection($applications);
  }

  public function startProject(Project $project)
  {
    if ($project->application()->first()->status !== "accepted") {
      return [
        "message" => "Can't start Project where application is unaccepted by the employer",
      ];
    }

    $project = Project::where("id", $project->id);
    $status = 'in_progress';
    $project->update(["tracking_status" => $status]);


    return [
      "message" => "Tracking status updated to In-progress",
      "data" => new ProjectResource($project)
    ];
  }
  public function completeProject(Project $project)
  {
    $project = Project::where("id", $project->id);
    $status = 'completed';
    $project->update(["tracking_status" => $status]);
    return [
      "message" => "Tracking status updated to In-progress",
      "data" => new ProjectResource($project)
    ];
  }
}
