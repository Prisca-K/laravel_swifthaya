<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\Project;
use App\Models\Swifthayajob;
use App\Models\User_profile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
  // List all applications
  public function index()
  {
    try {
      // Fetch and paginate applications
      $applications = Application::latest()->paginate(10);

      return ApplicationResource::collection($applications);
    } catch (Exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);  // No DB transaction here, so no rollback needed
    }
  }

  // Apply for a project
  public function applyForProject(Project $project)
  {
    DB::beginTransaction(); // Start transaction

    try {
      $user = Auth::user();  // Get authenticated user
      $user_profile = User_profile::where("user_id", $user->id)->first();
      $talent_profile = $user_profile->talentprofile;

      // Check if user has a talent profile before applying
      if (is_null($talent_profile)) {
        throw new Exception("User does not have a talent profile.");
      }

      // Check if talent profile is approved
      if ($user->status !== "approved" || $talent_profile->status !== "approved") {
        throw new Exception("Your profile has not been approved.");
      }

      // Check if user already applied for the project
      $has_applied_to_project = Application::where([
        "applicant_id" => $user->id,
        "project_id" => $project->id,
      ])->exists();

      if ($has_applied_to_project) {
        throw new Exception("You have already applied for this project.");
      }

      // Store the application in the database
      $application = $user->applications()->create([
        "applicant_id" => $user->id,
        "project_id" => $project->id,
      ]);

      DB::commit(); // Commit transaction

      return response()->json([
        "message" => "Application successful.",
        "data" => new ApplicationResource($application),
      ], 201);
    } catch (Exception $e) {
      DB::rollBack(); // Rollback transaction on error
      return response()->json(["message" => $e->getMessage()], 400);
    }
  }

  // Apply for a job
  public function applyForJob(Swifthayajob $job)
  {
    DB::beginTransaction(); // Start transaction

    try {
      $user = Auth::user();  // Get authenticated user
      $user_profile = User_profile::where("user_id", $user->id)->first();
      $talent_profile = $user_profile->talentprofile;

      // Check if user has a talent profile before applying
      if (is_null($talent_profile)) {
        throw new Exception("User does not have a talent profile.");
      }

      // Check if talent profile is approved
      if ($user->status !== "approved" || $talent_profile->status !== "approved") {
        throw new Exception("Your profile has not been approved.");
      }

      // Check if user already applied for the job
      $has_applied_to_job = Application::where([
        "applicant_id" => $user->id,
        "swifthayajob_id" => $job->id,
      ])->exists();

      if ($has_applied_to_job) {
        throw new Exception("You have already applied for this job.");
      }

      // Store the application in the database
      $application = $user->applications()->create([
        "applicant_id" => $user->id,
        "swifthayajob_id" => $job->id,
      ]);

      DB::commit(); // Commit transaction

      return response()->json([
        "message" => "Application successful.",
        "data" => new ApplicationResource($application),
      ], 201);
    } catch (Exception $e) {
      DB::rollBack(); // Rollback transaction on error
      return response()->json(["message" => $e->getMessage()], 400);
    }
  }

  // Get all job applications
  public function jobApplications()
  {
    try {
      // Fetch and paginate job applications
      $applications = Application::whereNotNull("swifthayajob_id")->latest()->paginate(10);

      return ApplicationResource::collection($applications);
    } catch (Exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }

  // Get all project applications
  public function projectApplications()
  {
    try {
      // Fetch and paginate project applications
      $applications = Application::whereNotNull("project_id")->latest()->paginate(10);

      return ApplicationResource::collection($applications);
    } catch (Exception $e) {
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }

  // Delete an application
  public function destroy(Application $application)
  {
    DB::beginTransaction(); // Start transaction

    try {
      // Delete application
      $application->delete();

      DB::commit(); // Commit transaction

      return response()->json(['message' => 'Application deleted successfully.'], 200);
    } catch (Exception $e) {
      DB::rollBack(); // Rollback transaction on error
      return response()->json(['message' => $e->getMessage()], 400);
    }
  }
}
