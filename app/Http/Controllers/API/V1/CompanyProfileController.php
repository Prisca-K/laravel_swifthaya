<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompany_profileRequest;
use App\Http\Requests\UpdateCompany_profileRequest;
use App\Http\Resources\CompanyProfileResource;
use App\Models\Company_profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Exception;

class CompanyProfileController extends Controller
{
  // Show company profile
  public function show()
  {
    try {
      $company_profile = Auth::user()->userprofile->companyprofile;
      if (!$company_profile) {
        return response()->json(["message" => "User has no company profile"]);
      }
      Gate::authorize("modify", $company_profile);

      return new CompanyProfileResource($company_profile);
    } catch (Exception $e) {
      return response()->json(['message' => 'Failed to retrieve company profile', 'error' => $e->getMessage()], 500);
    }
  }

  // Store company profile
  public function store(StoreCompany_profileRequest $request)
  {
    DB::beginTransaction(); // Begin transaction

    try {
      $user = Auth::user();
      $validated = $request->validated();
      $has_company_profile = Company_profile::where("user_profile_id", $user->userprofile->id)->first();

      if (!is_null($has_company_profile)) {
        Gate::authorize("modify", $has_company_profile);
        return [
          'message' => "User already has a company profile",
          new CompanyProfileResource($has_company_profile)
        ];
      }

      $company_profile = $user->userprofile->companyprofile()->create([
        'user_profile_id' => $user->userprofile->id,
        'company_name' => $validated["company_name"],
        'industry' =>  $validated["industry"],
        'company_size' => $validated["company_size"],
        'founded_year' =>  $validated["founded_year"],
      ]);

      $company_profile->refresh(); // Reload the model to get the default values (e.g., pending status)

      DB::commit(); // Commit transaction

      return ["message" => "Company profile created successfully", "data" => new CompanyProfileResource($company_profile)];
    } catch (Exception $e) {
      DB::rollBack(); // Rollback on error
      return response()->json(['message' => 'Failed to create company profile', 'error' => $e->getMessage()], 500);
    }
  }

  // Update company profile
  public function update(UpdateCompany_profileRequest $request, Company_profile $company_profile)
  {
    DB::beginTransaction(); // Begin transaction

    try {
      Gate::authorize("modify", $company_profile);
      $validated = $request->validated();

      $company_profile->update([
        'company_name' => $validated["company_name"],
        'industry' => $validated["industry"],
        'company_size' => $validated["company_size"],
        'founded_year' =>  $validated["founded_year"],
      ]);

      DB::commit(); // Commit transaction

      return ["message" => "Company profile updated successfully", "data" => new CompanyProfileResource($company_profile)];
    } catch (Exception $e) {
      DB::rollBack(); // Rollback on error
      return response()->json(['message' => 'Failed to update company profile', 'error' => $e->getMessage()], 500);
    }
  }

  // Delete company profile
  public function destroy(Company_profile $company_profile)
  {
    DB::beginTransaction(); // Begin transaction

    try {
      Gate::authorize("delete", $company_profile);
      $company_profile->delete();
      $company_profile->userprofile->user->delete();
      DB::commit(); // Commit transaction

      return response()->json(["message" => "Company profile deleted successfully"]);
    } catch (Exception $e) {
      DB::rollBack(); // Rollback on error
      return response()->json(['message' => 'Failed to delete company profile', 'error' => $e->getMessage()], 500);
    }
  }
}
