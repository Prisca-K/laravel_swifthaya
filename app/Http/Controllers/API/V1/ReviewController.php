<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Exception;

class ReviewController extends Controller
{
  public function reviewer()
  {
    try {
      // Get reviews made by the authenticated user
      $user_id = Auth::user()->id;
      $reviews = Review::where("reviewer_id", $user_id)->get();
      return ReviewResource::collection($reviews);
    } catch (Exception $e) {
      return response()->json(['message' => 'Failed to retrieve reviews', 'error' => $e->getMessage()], 500);
    }
  }

  public function reviewee()
  {
    try {
      // Get reviews received by the authenticated user
      $user_id = Auth::user()->id;
      $reviews = Review::where("reviewee_id", $user_id)->get();
      return ReviewResource::collection($reviews);
    } catch (Exception $e) {
      return response()->json(['message' => 'Failed to retrieve reviews', 'error' => $e->getMessage()], 500);
    }
  }

  public function store(StoreReviewRequest $request, $reviewee_id)
  {
    DB::beginTransaction(); // Begin DB transaction

    try {
      $validated = $request->validated();

      $validated['reviewer_id'] = Auth::user()->id;

      $review = Review::create($validated);

      $review->refresh(); // Reload the model to get the default values (e.g., pending status)

      DB::commit(); // Commit transaction

      return ["message" => "Review created successfully", "data" => new ReviewResource($review)];
    } catch (Exception $e) {
      DB::rollBack(); // Rollback in case of failure
      return response()->json(['message' => 'Failed to create review', 'error' => $e->getMessage()], 500);
    }
  }

  public function update(StoreReviewRequest $request, Review $review)
  {
    Gate::authorize('update', $review);
    DB::beginTransaction(); // Begin DB transaction

    try {

      $validated = $request->validated();
      $review->update($validated);

      DB::commit(); // Commit transaction

      return ["message" => "Review updated successfully", "data" => new ReviewResource($review)];
    } catch (Exception $e) {
      DB::rollBack(); // Rollback in case of failure
      return response()->json(['message' => 'Failed to update review', 'error' => $e->getMessage()], 500);
    }
  }

  public function destroy(Review $review)
  {
    Gate::authorize('delete', $review);
    DB::beginTransaction(); // Begin DB transaction

    try {
      $review->delete();

      DB::commit(); // Commit transaction

      return response()->json(
        ["message" => "Review deleted successfully"]
      );
    } catch (Exception $e) {
      DB::rollBack(); // Rollback in case of failure
      return response()->json(['message' => 'Failed to delete review', 'error' => $e->getMessage()], 500);
    }
  }
}
