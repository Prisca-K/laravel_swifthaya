<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Project;
use App\Models\Swifthayajob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
  public function index()
  {
    // Fetch jobs or projects based on the user's role or selection
    $appliedjobs = Application::where(["applicant_id" => Auth::user()->id, "status" => "accepted"])->get();
    // dd($appliedjob);

    return view('shared.tracker', compact('appliedjobs'));
  }
  public function showPendingProjects()
  {
    $projects = Swifthayajob::where('tracking_status', 'pending')->get();

    return view('Projects.mark-as-started', compact('projects'));
  }

  public function startJob(Swifthayajob $job)
  {

    $job = Swifthayajob::where("id", $job->id);
    $status = 'in_progress';
    $job->update(["tracking_status" => $status]);
    // dd($job);


    return redirect()->route('tracking.index')->with('success', 'Job marked as started successfully!');
  }


  public function show($id)
  {
    $item = Swifthayajob::findOrFail($id);
    return view('tracking.show', compact('item'));
  }

  public function complete(Swifthayajob $job)
  {
    $job = Swifthayajob::where("id", $job->id);
    $status = 'completed';
    $job->update(["tracking_status" => $status]);
    // dd($job);
    return redirect()->route('tracking.index')->with('success', 'Job marked as completed!');
  }
  public function history()
  {
    $appliedjobs = Application::where(["applicant_id" => Auth::user()->id, "status" => "accepted"])->get();
    return view("shared.tracking_history", compact("appliedjobs"));
  }
}
