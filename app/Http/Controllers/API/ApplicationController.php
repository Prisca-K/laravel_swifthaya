<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\Project;
use App\Models\Swifthayajob;
use App\Models\User_profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{

  // talents
  public function project_apply(Request $request, Project $project)
  {
    $user = Auth::user();
    $user_profile = User_profile::where("user_id", $user->id)->first();

    $talent_profile = $user_profile->talentprofile;
    // check if user has a talent profile before applying
    if (is_null($talent_profile)) {
      return response()->json(["message" => "User does not have a talent profile"]);
    }
    // check if talent profile is approved
    if (Auth::user()->status !== "approved" || $talent_profile->status !== "approved") {
      return response()->json(["message" => "your profile has not been approved"]);
    }
    // user doesn't apply for a job twice
    $has_applied_to_job = Application::where(["applicant_id" => Auth::user()->id, "project_id" => $project->id])->count();

    if ($has_applied_to_job > 0) {
      return response()->json(["message" => "User already applied for this job"]);
    }


    $validated = $request->validate([
      'job_title' => ['required', 'string', 'max:255'],
      'cover_letter' => ['required', 'string', 'min:100'],
      'attachments' => ['required', 'file', 'mimes:pdf,doc,docx,zip', 'max:5120'], // 5MB max size
      'applied_at' => 'nullable|date',
    ]);


    if ($request->has("attachments")) {
      $attachmentPath = $request->file("attachments")->store("attachments", "public");

      $validated["attachments"] = $attachmentPath;
      $validated["applied_at"] = now();
    }
    $validated["job_title"] = $job->title;
    // Store the job application in the database
    $application = $user->applications()->create($validated);
    return [
      "message" => "application successful",
      "data" => new ApplicationResource($application)
    ];
  }
  public function job_apply(Request $request, Swifthayajob $job)
  {
    $user = Auth::user();
    $user_profile = User_profile::where("user_id", $user->id)->first();

    $talent_profile = $user_profile->talentprofile;
    // check if user has a talent profile before applying
    if (is_null($talent_profile)) {
      return response()->json(["message" => "User does not have a talent profile"]);
    }
    // check if talent profile is approved
    if (Auth::user()->status !== "approved" || $talent_profile->status !== "approved") {
      return response()->json(["message" => "your profile has not been approved"]);
    }
    // user doesn't apply for a job twice
    $has_applied_to_job = Application::where(["applicant_id" => Auth::user()->id, "swifthayajob_id" => $job->id])->count();

    if ($has_applied_to_job > 0) {
      return response()->json(["message" => "User already applied for this job"]);
    }


    $validated = $request->validate([
      'job_title' => ['required', 'string', 'max:255'],
      'cover_letter' => ['required', 'string', 'min:100'],
      'attachments' => ['required', 'file', 'mimes:pdf,doc,docx,zip', 'max:5120'], // 5MB max size
      'applied_at' => 'nullable|date',
    ]);


    if ($request->has("attachments")) {
      $attachmentPath = $request->file("attachments")->store("attachments", "public");

      $validated["attachments"] = $attachmentPath;
      $validated["applied_at"] = now();
    }
    $validated["job_title"] = $job->title;
    // Store the job application in the database
    $application = $user->applications()->create($validated);
    return [
      "message" => "application successful",
      "data" => new ApplicationResource($application)
    ];
  }

  public function project_application_history()
  {
    $applications = Application::where("applicant_id", Auth::user()->id)->whereNotNull('project_id')->get();

    return  ApplicationResource::collection($applications);
  }
  public function job_application_history()
  {
    $applications = Application::where("applicant_id", Auth::user()->id)->whereNotNull('swifthayajob_id')->get();

    return  ApplicationResource::collection($applications);
  }

  // company or individual
  public function view_project_applicants()
  {
    $employerId = Auth::user()->id;
    $applicants = Application::whereHas('project', function ($query) use ($employerId) {
      $query->where('company_id', $employerId);
    })->get();

    return  ApplicationResource::collection($applicants);
  }
  public function view_job_applicants()
  {
    $employerId = Auth::user()->id;
    $applicants = Application::whereHas('swifthayajob', function ($query) use ($employerId) {
      $query->where('company_id', $employerId);
    })->get();

    return  ApplicationResource::collection($applicants);
  }

  public function accept(Application $application)
  {
    $application->status = 'accepted';
    $application->save();

    return redirect()->back()->with('success', 'Application accepted successfully.');
  }

  public function reject(Application $application)
  {
    $application->status = 'rejected';
    $application->save();

    return redirect()->back()->with('success', 'Application rejected successfully.');
  }
}
