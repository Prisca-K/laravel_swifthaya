<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSwifthayajobRequest;
use App\Http\Requests\UpdateSwifthayajobRequest;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\SwifthayajobResource;
use App\Models\Application;
use App\Models\Swifthayajob;
use App\Models\Talent_profile;
use App\Models\User;
use App\Models\User_profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class SwifthayajobController extends Controller
{
  public function index()
  {
    $user = Auth::user();

    $jobs = Swifthayajob::where("company_id", $user->id)->get();
    foreach ($jobs as $job) {
      Gate::authorize("view", $job);
    }

    return SwifthayajobResource::collection($jobs);
  }

  public function store(StoreSwifthayajobRequest $request)
  {
    $user = Auth::user();

    $skillsArray = explode(',', request()->required_skills);
    $validated = $request->validated();

    $validated["company_id"] = Auth::user()->id;
    $validated["required_skills"] = json_encode($skillsArray);

    $job = $user->swifthayajob()->create($validated);
    return new SwifthayajobResource($job);
  }

  public function show(Swifthayajob $job)
  {
    Gate::authorize("view", $job);
    return new SwifthayajobResource($job);
  }

  public function update(UpdateSwifthayajobRequest $request, Swifthayajob $job)
  {
    // dd($job);
    Gate::authorize("update", $job);
    $skillsArray = explode(',', request()->required_skills);

    $validated = $request->validated();

    $validated["required_skills"] = json_encode($skillsArray);

    $job->update($validated);
    return new SwifthayajobResource($job);
  }

  public function destroy(Swifthayajob $job)
  {
    Gate::authorize("delete", $job);
    $job->delete();
    return response()->json(["message" => "Job deleted successfully"]);
  }

  public function offer_job()
  {
    // should return job offer from database
    // like offers where employerid = 1 

  }

  public function job_search(Request $request)
  {
    $query = Swifthayajob::with("user")->where('status', "approved");


    if (!empty($request->keyword)) {
      $query->where(function ($q) use ($request) {
        $q->orWhere('title', 'like', '%' . $request->keyword . '%');
        $q->orWhere('required_skills', 'like', '%' . $request->keyword . '%');
        $q->orWhere('location', 'like', '%' . $request->keyword . '%');
        $q->orWhere('job_type', 'like', '%' . $request->keyword . '%');
      });
    }


    // Filtering by title
    if ($request->filled('title')) {
      $title = $request->input('title');
      $query->where(function ($q) use ($title) {
        $q->where('title', 'like', '%' . $title . '%');
      });
    }
    // Filtering by required_skills
    if ($request->filled('required_skills')) {
      $required_skills = $request->input('required_skills');
      $query->where(function ($q) use ($required_skills) {
        $q->where('required_skills', 'like', '%' . $required_skills . '%');
      });
    }
    // Filtering by salary_range
    if ($request->filled('salary_range')) {
      $salary_range = $request->input('salary_range');
      $query->where(function ($q) use ($salary_range) {
        $q->where('salary_range', 'like', '%' . $salary_range . '%');
      });
    }



    // Filtering by location (location is in user_profile table)
    if ($request->filled('location')) {
      $location = $request->input('location');
      $query->where(function ($q) use ($location) {
        $q->where('location', 'like', '%' . $location . '%');
      });
    }

    // Filtering by job_type level
    if ($request->filled('job_type')) {
      $job_type = $request->input('job_type');
      $query->where(function ($q) use ($job_type) {
        $q->where('job_type', 'like', '%' . $job_type . '%');
      });
    }

    $jobs = $query->latest()->paginate(4);

    return view('talent.find_jobs', compact('jobs'));
  }
}
