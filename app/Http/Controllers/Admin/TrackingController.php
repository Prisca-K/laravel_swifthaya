<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\SwifthayajobResource;
use App\Models\Project;
use App\Models\Swifthayajob;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackingController extends Controller
{
  public function pendingJobs()
  {
    DB::beginTransaction(); // Start the transaction
    try {
      // Fetch jobs or projects based on the user's role or selection
      $status = "accepted";
      $jobs = Swifthayajob::where('tracking_status', "pending")->whereHas('application', function ($subQuery) use ($status) {
        $subQuery->where(["status" => $status]);
      })->get();

      DB::commit(); // Commit the transaction
      return SwifthayajobResource::collection($jobs);
    } catch (Exception $e) {
      DB::rollBack(); // Rollback the transaction if there’s an error
      return response()->json(['message' => 'Error fetching pending jobs', 'error' => $e->getMessage()], 500);
    }
  }
  public function startedJobs()
  {
    DB::beginTransaction(); // Start the transaction
    try {
      // Fetch jobs or projects based on the user's role or selection
      $status = "accepted";
      $jobs = Swifthayajob::where('tracking_status', "started")->whereHas('application', function ($subQuery) use ($status) {
        $subQuery->where(["status" => $status]);
      })->get();

      DB::commit(); // Commit the transaction
      return SwifthayajobResource::collection($jobs);
    } catch (Exception $e) {
      DB::rollBack(); // Rollback the transaction if there’s an error
      return response()->json(['message' => 'Error fetching started jobs', 'error' => $e->getMessage()], 500);
    }
  }
  public function completedJobs()
  {
    DB::beginTransaction(); // Start the transaction
    try {
      // Fetch jobs or projects based on the user's role or selection
      $status = "accepted";
      $jobs = Swifthayajob::where('tracking_status', "completed")->whereHas('application', function ($subQuery) use ($status) {
        $subQuery->where(["status" => $status]);
      })->get();

      DB::commit(); // Commit the transaction
      return SwifthayajobResource::collection($jobs);
    } catch (Exception $e) {
      DB::rollBack(); // Rollback the transaction if there’s an error
      return response()->json(['message' => 'Error fetching completed jobs', 'error' => $e->getMessage()], 500);
    }
  }
  public function pendingProjects()
  {
    DB::beginTransaction(); // Start the transaction
    try {
      // Fetch projects or projects based on the user's role or selection
      $status = "accepted";
      $projects = Project::where('tracking_status', "pending")->whereHas('application', function ($subQuery) use ($status) {
        $subQuery->where(["status" => $status]);
      })->get();

      DB::commit(); // Commit the transaction
      return ProjectResource::collection($projects);
    } catch (Exception $e) {
      DB::rollBack(); // Rollback the transaction if there’s an error
      return response()->json(['message' => 'Error fetching pending projects', 'error' => $e->getMessage()], 500);
    }
  }
  public function startedProjects()
  {
    DB::beginTransaction(); // Start the transaction
    try {
      // Fetch projects or projects based on the user's role or selection
      $status = "accepted";
      $projects = Project::where('tracking_status', "started")->whereHas('application', function ($subQuery) use ($status) {
        $subQuery->where(["status" => $status]);
      })->get();

      DB::commit(); // Commit the transaction
      return ProjectResource::collection($projects);
    } catch (Exception $e) {
      DB::rollBack(); // Rollback the transaction if there’s an error
      return response()->json(['message' => 'Error fetching started projects', 'error' => $e->getMessage()], 500);
    }
  }
  public function completedProjects()
  {
    DB::beginTransaction(); // Start the transaction
    try {
      // Fetch projects or projects based on the user's role or selection
      $status = "accepted";
      $projects = Project::where('tracking_status', "completed")->whereHas('application', function ($subQuery) use ($status) {
        $subQuery->where(["status" => $status]);
      })->get();

      DB::commit(); // Commit the transaction
      return ProjectResource::collection($projects);
    } catch (Exception $e) {
      DB::rollBack(); // Rollback the transaction if there’s an error
      return response()->json(['message' => 'Error fetching completed projects', 'error' => $e->getMessage()], 500);
    }
  }
}
