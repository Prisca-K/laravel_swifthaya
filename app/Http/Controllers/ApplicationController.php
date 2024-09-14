<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Company_profile;
use App\Models\Project;
use App\Models\Swifthayajob;
use App\Models\Talent_profile;
use App\Models\User;
use App\Models\User_profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
  /* jobs */
  public function job_apply(Swifthayajob $job)
  {
    $user_profile = User_profile::where("user_id", Auth::user()->id)->first();

    $talent_profile = Talent_profile::where("user_profile_id", $user_profile->id)->first();
    // check if user has a talent profile before applying
    if (is_null($talent_profile)) {
      return redirect()->route("talent.create", $user_profile->id);
    }
    // check if talent profile is approved
    if (Auth::user()->status !== "approved" || $talent_profile->status !== "approved") {
      return redirect()->route("talent.show")->with("error", "Your profile has not been approved");
    }
    // user doesn't apply for a job twice
    $has_applied_to_job = Application::where(["applicant_id" => Auth::user()->id, "swifthayajob_id" => $job->id])->count();
    if ($has_applied_to_job > 0) {
      return redirect()->route("job.application_history");
    }
    return view("talent.job_application_page", compact("job"));
  }

  // store job application
  public function job_store_application(Request $request, Swifthayajob $job)
  {

    // $has_applied_to_job = Application::where(["applicant_id" => Auth::user()->id, "swifthayajob_id" => $job->id])->count();
    // if ($has_applied_to_job > 0) {
    //   return redirect()->route("job.application_history", $user->id);
    // }

    $validated = $request->validate([
      'job_title' => ['required', 'string', 'max:255'],
      'cover_letter' => ['required', 'string', 'min:100'],
      'attachments' => ['required', 'file', 'mimes:pdf,doc,docx,zip', 'max:5120'], // 5MB max size
      'applied_at' => 'nullable|date',
    ]);

    // Store the job application in the database

    if ($request->has("attachments")) {
      $attachmentPath = $request->file("attachments")->store("attachments", "public");

      $validated["attachments"] = $attachmentPath;
    }
    Application::create([
      'applicant_id' => Auth::user()->id,
      'swifthayajob_id' => $job->id,
      'job_title' => $validated['job_title'],
      'cover_letter' => $validated['cover_letter'],
      'attachments' => $validated["attachments"],
      "applied_at" => now(),
    ]);


    return redirect()->route("job.application_history");
  }

  // job application history
  public function job_application_history()
  {

    $applications = Application::where("applicant_id", Auth::user()->id)->whereNotNull('swifthayajob_id')->get();
    return view("talent.job_application_history", compact("applications"));
  }

  
  /*  projects */

  // apply page
  public function project_apply(Project $project)
  {

    $user_profile = User_profile::where("user_id", Auth::user()->id)->first();

    // check if user has a talent profile before applying
    $talent_profile = Talent_profile::where("user_profile_id", $user_profile->id)->first();

    if (is_null($talent_profile)) {
      return redirect()->route("talent.create", $user_profile->id);
    }

    if (Auth::user()->status !== "approved" || $talent_profile->status !== "approved") {
      return redirect()->route("talent.show")->with("error", "Your profile has not been approved");
    }

    // user doesn't apply for a job twice
    $has_applied_to_project = Application::where(["applicant_id" => Auth::user()->id, "project_id" => $project->id])->count();

    // dd($has_applied_to_project);
    if ($has_applied_to_project > 0) {
      return redirect()->route("project.application_history");
    }
    return view("talent.project_application_page", compact("project"));
  }

  // store project application 
  public function project_store_application(Request $request, Project $project)
  {
    // // dd($project);
    // $has_applied_to_project = Application::where(["applicant_id" => Auth::user()->id, "project_id" => $project->id])->count();
    // if ($has_applied_to_project > 0) {
    //   return redirect()->route("project.application_history", $user->id);
    // }

    $validated = $request->validate([
      'project_title' => ['required', 'string', 'max:255'],
      'cover_letter' => ['required', 'string', 'min:100'],
      'attachments' => ['required', 'file', 'mimes:pdf,doc,docx,zip', 'max:5120'], // 5MB max size
      'applied_at' => 'nullable|date',
    ]);

    // Store the project application in the database

    if ($request->has("attachments")) {
      $attachmentPath = $request->file("attachments")->store("attachments", "public");

      $validated["attachments"] = $attachmentPath;
    }
    Application::create([
      'applicant_id' => Auth::user()->id,
      'project_id' => $project->id,
      'project_title' => $validated['project_title'],
      'cover_letter' => $validated['cover_letter'],
      'attachments' => $validated["attachments"],
      "applied_at" => $validated["applied_at"],
    ]);

    return redirect()->route("project.application_history");
  }

  // job application history
  public function project_application_history()
  {
    $applications = Application::where("applicant_id", Auth::user()->id)->whereNotNull('project_id')->get();
    return view("talent.project_application_history", compact("applications"));
  }


  public function job_details(Application $application)
  {
    // dd($application->swifthayajob);

    return view("shared.view_application_details", compact("application"));
  }
  public function show(Application $application)
  {
    // dd($application->swifthayajob);

    return view("shared.view_applicants_details", compact("application"));
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
