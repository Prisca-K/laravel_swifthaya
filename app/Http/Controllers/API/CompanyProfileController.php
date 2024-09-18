<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompany_profileRequest;
use App\Http\Requests\UpdateCompany_profileRequest;
use App\Http\Resources\CompanyProfileResource;
use App\Models\Company_profile;
use App\Policies\Company_profilePolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CompanyProfileController extends Controller
{
  // show store update delete
  public function show()
  {
    $company_profile = Auth::user()->userprofile->companyprofile;
    // dd($talent_profile);
    Gate::authorize("modify", $company_profile);

    return new CompanyProfileResource($company_profile);
  }

  public function store(StoreCompany_profileRequest $request)
  {
    $user = Auth::user();
    $validated = $request->validated();
    $has_company_profile = Company_profile::where("user_profile_id", $user->userprofile->id)->first();

    if (!is_null($has_company_profile)) {
      Gate::authorize("modify", $has_company_profile);
      $company_profile = $has_company_profile;
      return [
        'message' => "User already has a company profile",
        new CompanyProfileResource($has_company_profile)
      ];
    }
    $company_profile = $user->userprofile->companyprofile()->create(
      [
        'user_profile_id' => $user->userprofile->id,
        'company_name' => $validated["company_name"],
        'industry' =>  $validated["industry"],
        'company_size' => $validated["company_size"],
        'founded_year' =>  $validated["founded_year"],
      ]
    );
    return new CompanyProfileResource($company_profile);
  }

  public function update(UpdateCompany_profileRequest $request, Company_profile $company_profile)
  {
    Gate::authorize("modify", $company_profile);
    $validated = $request->validated();
    $company_profile->update(
      [
        'company_name' => $validated["company_name"],
        'industry' => $validated["industry"],
        'company_size' => $validated["company_size"],
        'founded_year' =>  $validated["founded_year"],
      ]
    );
    return new CompanyProfileResource($company_profile);
  }
  public function destroy(Company_profile $company_profile)
  {
    Gate::authorize("delete", $company_profile);
    $company_profile->delete();
    return response()->json(["message" => "company deleted successfully"]);
  }
}
