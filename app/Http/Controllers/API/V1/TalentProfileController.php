<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTalent_profileRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\SwifthayajobResource;
use App\Http\Resources\TalentProfileResource;
use App\Models\Project;
use App\Models\Swifthayajob;
use App\Models\Talent_profile;
use App\Models\User_profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Exception;

class TalentProfileController extends Controller
{
  public function show()
  {
    try {
      $talent_profile = Auth::user()->userprofile->talentprofile;
      if (!$talent_profile) {
        return response()->json(["message" => "User has no talent profile"]);
      }
      Gate::authorize("view", $talent_profile);

      return new TalentProfileResource($talent_profile);
    } catch (Exception $e) {
      DB::rollBack(); // Rollback in case of failure
      return response()->json(['message' => 'Failed to retrieve Talent Profile', 'error' => $e->getMessage()], 500);
    }
  }

  public function store(StoreTalent_profileRequest $request)
  {
    DB::beginTransaction(); // Begin DB transaction

    try {
      $user_profile = Auth::user()->userprofile;
      $has_talent_profile = Talent_profile::where("user_profile_id", $user_profile->id)->first();

      // check if user already has Talent profile
      if (!is_null($has_talent_profile)) {
        Gate::authorize("update", $has_talent_profile);
        DB::commit(); // Commit if no changes are required

        return [
          'message' => "User already has a talent profile",
          new TalentProfileResource($has_talent_profile)
        ];
      }


      $validated = $request->validated();

      $skillsArray = explode(',', $validated["skills"]);
      $experienceArray = $validated["experience"];
      $educationArray = $validated["education"];
      $portfolioArray = $validated["portfolio"];

      // create talent profile
      $talent_profile = $user_profile->talentprofile()->create([
        'user_profile_id' => $user_profile->id,
        'skills' => json_encode($skillsArray),
        'experience' => json_encode($experienceArray),
        'education' => json_encode($educationArray),
        'portfolio' => json_encode($portfolioArray)
      ]);

      $talent_profile->refresh(); // Reload the model to get the default values (e.g., pending status)

      DB::commit(); // Commit transaction on success

      return [
        'message' => "Talent profile created successfully",
        new TalentProfileResource($talent_profile)
      ];
    } catch (Exception $e) {
      DB::rollBack(); // Rollback in case of failure
      return response()->json(['message' => 'Failed to create Talent Profile', 'error' => $e->getMessage()], 500);
    }
  }

  public function update(StoreTalent_profileRequest $request, Talent_profile $talent_profile)
  {
    Gate::authorize("update", $talent_profile);

    DB::beginTransaction(); // Begin DB transaction

    try {
      $validated = $request->validated();

      $skillsArray = explode(',', $validated["skills"]);
      $experienceArray = $validated["experience"];
      $educationArray = $validated["education"];
      $portfolioArray = $validated["portfolio"];
      // update talent profile
      $talent_profile->update([
        'skills' => json_encode($skillsArray),
        'experience' => json_encode($experienceArray),
        'education' => json_encode($educationArray),
        'portfolio' => json_encode($portfolioArray)
      ]);

      DB::commit(); // Commit transaction on success

      return ["message" => "Talent profile updated successfully", "data" => new TalentProfileResource($talent_profile)];
    } catch (Exception $e) {
      DB::rollBack(); // Rollback on failure
      return response()->json(['message' => 'Failed to update Talent Profile', 'error' => $e->getMessage()], 500);
    }
  }

  public function destroy(Talent_profile $talent_profile)
  {
    Gate::authorize("delete", $talent_profile);

    DB::beginTransaction(); // Begin DB transaction

    try {
      $talent_profile->delete();
      $talent_profile->userprofile->user->delete();
      DB::commit(); // Commit transaction on success

      return response()->json([
        "message"  => "Talent Profile deleted successfully"
      ]);
    } catch (Exception $e) {
      DB::rollBack(); // Rollback in case of failure
      return response()->json(['message' => 'Failed to delete Talent Profile', 'error' => $e->getMessage()], 500);
    }
  }

  public function talent_search(Request $request)
  {
    try {
      $query = Talent_profile::with("userprofile")->where('status', "approved");


      if (!empty($request->keyword)) {
        $query->where(function ($q) use ($request) {
          $q->orWhere('skills', 'like', '%' . $request->keyword . '%');
          $q->orWhere('skills', 'like', '%' . $request->keyword . '%');
          $q->orWhere('education', 'like', '%' . $request->keyword . '%');
          $q->orWhere('experience', 'like', '%' . $request->keyword . '%');
        });
      }


      // Filtering by skills
      if ($request->filled('skills')) {
        $skills = $request->input('skills');
        $query->where(function ($q) use ($skills) {
          $q->where('skills', 'like', '%' . $skills . '%');
        });
      }


      // Filtering by location (assuming location is in user_profile table)
      if ($request->filled('location')) {
        $location = $request->input('location');
        $query->whereHas('userprofile', function ($q) use ($location) {
          $q->where('location', 'like', '%' . $location . '%');
        });
      }

      // Filtering by experience level
      if ($request->filled('experience')) {

        $experience = intval(request()->input('experience'));

        $query->whereJsonContains('experience->experience', ['duration' => $experience]);
        $query->where(function ($q) use ($experience) {
          $q->where('experience', 'like', '%' . $experience . '%');
        });
      }

      $talents = $query->latest()->paginate(10);

      return TalentProfileResource::collection($talents);
    } catch (Exception $e) {
      return response()->json(['message' => 'Failed to search for Talents', 'error' => $e->getMessage()], 500);
    }
  }
}
