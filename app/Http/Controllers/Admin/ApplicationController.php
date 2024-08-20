<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
  public function index()
  {
    $jobApplications = Application::with('swifthayajob','userprofile')->whereNotNull("swifthayajob_id")->paginate(10);

    $projectApplications = Application::with('project','userprofile')->whereNotNull("project_id")->paginate(10);
    return view('admin.applications.index', compact('jobApplications', 'projectApplications'));
  }

  public function edit(Application $application)
  {
    return view('admin.applications.edit', compact('application'));
  }

  public function update(Request $request, Application $application)
  {
    $request->validate([
      'status' => 'required|string|max:255',
      'cover_letter' => ['required', 'string', 'min:100'],
    ]);

    $application->update($request->all());

    return redirect()->route('admin.applications')->with('success', 'Application updated successfully.');
  }

  public function destroy(Application $application)
  {
    $application->delete();
    return redirect()->route('admin.applications')->with('success', 'Application deleted successfully.');
  }
}
