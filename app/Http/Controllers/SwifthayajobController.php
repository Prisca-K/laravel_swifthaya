<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompany_profileRequest;
use App\Http\Requests\StoreSwifthayajobRequest;
use App\Http\Requests\UpdateCompany_profileRequest;
use App\Http\Requests\UpdateSwifthayajobRequest;
use App\Models\Company_profile;
use App\Models\Swifthayajob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use PhpParser\Node\Stmt\Switch_;

use function PHPUnit\Framework\isEmpty;

class SwifthayajobController extends Controller
{


  public function index(User $user)
  {
    $jobs = Swifthayajob::where("company_id", $user->id)->get();
    if (count($jobs) === 0) {
      return redirect()->route("job.create", $user->id);
    }
    foreach ($jobs as $job) {
      Gate::authorize("view", $job);
    }

    return view("company.jobs.job_posts", compact('user', "jobs"));
  }

  public function create(User $user)
  {
    // dd()
    return view("company.jobs.create_job", compact('user'));
  }

  public function store(StoreSwifthayajobRequest $request, User $user)
  {
    $validated = $request->validated();
    $validated["company_id"] = $user->id;

    Swifthayajob::create($validated);
    return redirect()->route("jobs", $user->id);
  }

  public function show(Swifthayajob $job)
  {
    Gate::authorize("view", $job);
    // dd($job);
    return view("company.jobs.view_job", compact("job"));
  }

  public function edit(Swifthayajob $job)
  {
    Gate::authorize("update", $job);
    $user = User::where("id", $job->company_id)->first();

    return view("company.jobs.edit_job", compact("job", "user"));
  }

  public function update(UpdateSwifthayajobRequest $request, Swifthayajob $job)
  {
    // dd($job);
    Gate::authorize("update", $job);
    $validated = $request->validated();
    $user = User::where("id", $job->company_id)->first();
    $validated["company_id"] = $user->id;
    $job->update($validated);
    return redirect()->route("company.dashboard", $user->id);
  }

  public function destroy(Swifthayajob $job)
  {
    Gate::authorize("delete", $job);
    $job->delete();
    return redirect()->route("jobs", auth()->id());
  }

}
