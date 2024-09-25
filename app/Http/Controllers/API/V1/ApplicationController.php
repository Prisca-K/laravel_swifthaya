<?php

namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\SwifthayajobResource;
use App\Http\Resources\UserResource;
use App\Models\Application;
use App\Models\Project;
use App\Models\Swifthayajob;
use App\Models\User;
use App\Models\User_profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class ApplicationController extends Controller
{
  // talents
  public function applyForProject(Project $project)
  {
    DB::beginTransaction(); // Start transaction

    try {
      $user = Auth::user();
      $user_profile = User_profile::where("user_id", $user->id)->first();
      $talent_profile = $user_profile->talentprofile;

      // Check if user has a talent profile before applying
      if (is_null($talent_profile)) {
        throw new Exception("User does not have a talent profile");
      }

      // Check if talent profile is approved
      if ($user->status !== "approved" || $talent_profile->status !== "approved") {
        throw new Exception("Your profile has not been approved");
      }

      // Check if user already applied for the project
      $has_applied_to_project = Application::where([
        "applicant_id" => $user->id,
        "project_id" => $project->id,
      ])->count();

      if ($has_applied_to_project > 0) {
        throw new Exception("User already applied for this project");
      }

      // if ($request->has("attachments")) {
      //   $attachmentPath = $request->file("attachments")->store("attachments", "public");
      //   $validated["attachments"] = $attachmentPath;
      // }

      // Store the job application in the database
      $application = $user->applications()->create([
        "applicant_id" => $user->id,
        "project_id" => $project->id,
      ]);

      $application->refresh(); // Reload the model to get the default values (e.g., pending status)
      DB::commit(); // Commit transaction
      return [
        "message" => "Application successful",
        "data" => new ApplicationResource($application),
      ];
    } catch (Exception $e) {
      DB::rollBack(); // Rollback transaction on error
      return response()->json(["message" => $e->getMessage()], 400);
    }
  }

  public function applyForJob(Swifthayajob $job)
  {
    DB::beginTransaction(); // Start transaction

    try {
      $user = Auth::user();
      $user_profile = User_profile::where("user_id", $user->id)->first();
      $talent_profile = $user_profile->talentprofile;

      // Check if user has a talent profile before applying
      if (is_null($talent_profile)) {
        throw new Exception("User does not have a talent profile");
      }

      // Check if talent profile is approved
      if ($user->status !== "approved" || $talent_profile->status !== "approved") {
        throw new Exception("Your profile has not been approved");
      }

      // Check if user already applied for the job
      $has_applied_to_job = Application::where([
        "applicant_id" => $user->id,
        "swifthayajob_id" => $job->id,
      ])->count();

      if ($has_applied_to_job > 0) {
        throw new Exception("User already applied for this job");
      }


      // if ($request->has("attachments")) {
      //   $attachmentPath = $request->file("attachments")->store("attachments", "public");
      //   $validated["attachments"] = $attachmentPath;
      //   $validated["applied_at"] = now();
      // }

      // Store the job application in the database
      $application = $user->applications()->create([
        "applicant_id" => $user->id,
        "swifthayajob_id" => $job->id,
      ]);

      $application->refresh(); // Reload the model to get the default values (e.g., pending status)
      DB::commit(); // Commit transaction
      return [
        "message" => "Application successful",
        "data" => new ApplicationResource($application),
      ];
    } catch (Exception $e) {
      DB::rollBack(); // Rollback transaction on error
      return response()->json(["message" => $e->getMessage()], 400);
    }
  }

  // All projects that a specific talent have applied to

  public function projectApplications()
  {
    try {
      $applicant_id = Auth::user()->id;

      $projects = Project::whereHas('application', function ($subQuery) use ($applicant_id) {
        $subQuery->where(["applicant_id" => $applicant_id]);
      })->get();
      return ProjectResource::collection($projects);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }

  // All jobs that a specific talent have applied to
  public function jobApplications()
  {
    $applicant_id = Auth::user()->id;
    try {
      $jobs = Swifthayajob::whereHas('application', function ($subQuery) use ($applicant_id) {
        $subQuery->where(["applicant_id" => $applicant_id]);
      })->get();

      return SwifthayajobResource::collection($jobs);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }

  // company or individual
  // user that applied to a specific project
  public function view_project_applicants($project_id)
  {
    try {
      $employerId = Auth::user()->id;
      $applicants = User::whereHas("applications", function ($query) use ($project_id) {
        $query->where('project_id', $project_id);
      })->get();
      return UserResource::collection($applicants);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }

  // user that applied to a specific job
  public function view_job_applicants($job_id)
  {
    try {
      $employerId = Auth::user()->id;
      $applicants = User::whereHas("applications", function ($query) use ($job_id) {
        $query->where('swifthayajob_id', $job_id);
      })->get();
      return UserResource::collection($applicants);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }

  public function accept(Application $application)
  {
    DB::beginTransaction();

    try {
      // Set the application status to 'rejected'

      $application->status = 'accepted';
      $application->save();

      DB::commit();

      return response()->json(['message' => 'Application accepted successfully.']);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }

  public function reject(Application $application)
  {
    DB::beginTransaction();

    try {
      // Set the application status to 'rejected'

      $application->status = 'rejected';
      $application->save();

      DB::commit();

      return response()->json(['message' => 'Application rejected successfully.']);
    } catch (Exception $e) {
      DB::rollBack();
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }
}
