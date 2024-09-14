<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSwifthayajobRequest;
use App\Http\Requests\UpdateSwifthayajobRequest;
use App\Models\Company_profile;
use App\Models\Swifthayajob;
use App\Models\User;
use App\Models\User_profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SwifthayajobController extends Controller
{

  public function index()
  {
    $jobs = Swifthayajob::paginate(10);
    // foreach ($jobs as $job) {
    //   // dd($job->user->userprofile->companyprofile);
    // }
    return view('admin.jobs.index', compact('jobs'));
  }

  public function create()
  {
    $user_profile = User_profile::where("user_id", Auth::user()->id)->first();
    $hasCompanyProfile = Company_profile::where("user_profile_id", $user_profile->id)->exists();
    // dd($hasCompanyProfile);
    if ($hasCompanyProfile) {
      $users = User::where("user_type", "company")->get();
      return view('admin.jobs.create', compact('users'));
    }
    return redirect()->route("admin.companies.create", $user_profile->id);
  }

  public function store(StoreSwifthayajobRequest $request)
  {
    $validated = $request->validated();
    $validated["company_id"] = Auth::user()->id;
    $user_profile = User_profile::where("user_id", Auth::user()->id)->first();
    $hasCompanyProfile = Company_profile::where("user_profile_id", $user_profile->id)->exists();
    // dd($hasCompanyProfile);
    if ($hasCompanyProfile) {
      Swifthayajob::create($validated);
      return redirect()->route('admin.jobs')->with('success', 'Job created successfully.');
    }
    return redirect()->route("admin.companies.create", $user_profile->id);


    // I need someone good in mobile designs to join my team, we are on a serious project and we would pay based on your expertise
  }

  public function edit(Swifthayajob $job)
  {
    $users = User::where("user_type", "company")->get();
    return view('admin.jobs.edit', compact('job', 'users'));
  }

  public function update(UpdateSwifthayajobRequest $request, Swifthayajob $job)
  {
    $validated = $request->validated();
    $validated["company_id"] = $job->user->id;
    $job->update($validated);
    return redirect()->route('admin.jobs')->with('success', 'Job updated successfully.');
  }

  public function destroy(Swifthayajob $job)
  {
    $job->delete();
    return redirect()->route('admin.jobs')->with('success', 'Job deleted successfully.');
  }
  public function approvejob(Swifthayajob $job)
  {
    $job = Swifthayajob::where("id", $job->id);
    $status = $job->status = 'approved';
    $job->update(["status" => $status]);

    return redirect()->route('admin.jobs')->with('success', 'Job has been approved successfully.');
  }

  // Reject job
  public function rejectjob(Swifthayajob $job)
  {
    $job = Swifthayajob::where("id", $job->id);
    $status = $job->status = 'rejected';
    $job->update(["status" => $status]);

    return redirect()->route('admin.jobs')->with('error', 'Job has been rejected.');
  }
}
