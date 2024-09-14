<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
  public function index()
  {
    $projects = Project::paginate(10);
    return view('admin.projects.index', compact('projects'));
  }

  public function create()
  {
    return view('admin.projects.create');
  }

  public function store(StoreProjectRequest $request)
  {
    $validated = $request->validated();
    $validated["poster_id"] = Auth::user()->id;
    Project::create($validated);

    return redirect()->route('admin.projects')->with('success', 'Project created successfully.');
  }

  public function edit(Project $project)
  {
    return view('admin.projects.edit', compact('project'));
  }

  public function update(UpdateProjectRequest $request, Project $project)
  {

    $validated = $request->validated();
    $validated["poster_id"] = $project->user->id;
    $project->update($validated);
    return redirect()->route('admin.projects')->with('success', 'Project updated successfully.');
  }

  public function destroy(Project $project)
  {
    $project->delete();
    return redirect()->route('admin.projects')->with('success', 'Project deleted successfully.');
  }
  public function approveProject(Project $project)
  {
    $project = Project::where("id", $project->id);
    $status = $project->status = 'approved';
    $project->update(["status" => $status]);

    return redirect()->route('admin.projects')->with('success', 'Project has been approved successfully.');
  }

  // Reject project
  public function rejectProject(Project $project)
  {
    $project = Project::where("id", $project->id);
    $status = $project->status = 'rejected';
    $project->update(["status" => $status]);

    return redirect()->route('admin.projects')->with('error', 'Project has been rejected.');
  }
}
