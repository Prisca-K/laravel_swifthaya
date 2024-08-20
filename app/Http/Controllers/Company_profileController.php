<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompany_profileRequest;
use App\Http\Requests\UpdateCompany_profileRequest;
use App\Models\Company_profile;
use App\Models\Conversation;
use App\Models\Project;
use App\Models\Swifthayajob;
use App\Models\User;
use App\Models\User_profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Company_profileController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(User $user)
  {
    if ($user->user_type !== "admin" || $user->id !== Auth::user()->id) {
      abort("403");
    }
    $user_profile = User_profile::where("user_id", $user->id)->first();
    $company_profile = Company_profile::where("user_profile_id", $user_profile->id)->first();
    $jobs = Swifthayajob::where("company_id", $user->id)->get();
    $projects = Project::where("poster_id", $user->id)->get();
    // dd($jobs);

    $conversation = Conversation::where("user_id", Auth::user()->id)->first();
    // dd($conversation);
    // $recipient_id = $conversation->recipient_id;

    return view("company.dashboard", compact("user_profile", "jobs", "user", "projects"));
  }

  public function create(User_profile $user_profile)
  {
    $company_profile = Company_profile::where("user_profile_id", $user_profile->id)->first();
    if (!is_null($company_profile)) {
      Gate::authorize("view", $company_profile);
      return redirect()->route('profile.edit', $user_profile->id)->with('status', 'profile-updated');
    }
    return view("company.create_profile", compact("user_profile"));
  }


  public function store(StoreCompany_profileRequest $request, User_profile $user_profile)
  {
    $validated = $request->validated();
    $has_company_profile = Company_profile::where("user_profile_id", $user_profile->id)->first();

    if ($has_company_profile) {
      Gate::authorize("update", $has_company_profile);
    }
    if (!$has_company_profile) {
      $company_profile = Company_profile::create(
        [
          'user_profile_id' => $user_profile->id,
          'company_name' => $validated["company_name"],
          'industry' =>  $validated["industry"],
          'company_size' => $validated["company_size"],
          'founded_year' =>  $validated["founded_year"],
        ]
      );
      return redirect()->route('profile.edit', $user_profile->id)->with('status', 'profile-updated');
    }
    $company_profile = $has_company_profile;
    return view("company.view_profile", compact("user_profile", "company_profile"));
  }


  public function show(User_profile $user_profile)
  {
    $company_profile = Company_profile::where("user_profile_id", $user_profile->id)->first();
    Gate::authorize("view", $company_profile);
    return view("company.view_profile", compact("user_profile", "company_profile"));
  }


  // doing the edit in the profile

  // public function edit(User_profile $user_profile)
  // {
  //   Gate::authorize("update", $company_profile);

  //   return view("company.edit_profile", compact("company_profile"));
  // }


  public function update(UpdateCompany_profileRequest $request, Company_profile $profile)
  {
    Gate::authorize("update", $profile);
    $validated = $request->validated();

    $profile->update(
      [
        'user_profile_id' => $profile->id,
        'company_name' => $validated["company_name"],
        'industry' =>  $validated["industry"],
        'company_size' => $validated["company_size"],
        'founded_year' =>  $validated["founded_year"],
      ]
    );
    // because it now located at the user profile page
    return redirect()->route('profile.edit', $profile->id)->with('status', 'profile-updated');
  }


  public function destroy(Company_profile $company_profile)
  {
    Gate::authorize("delete", $company_profile);
    $company_profile->delete();
    return redirect()->route("company.dashboard", Auth::user()->id);
  }
}
