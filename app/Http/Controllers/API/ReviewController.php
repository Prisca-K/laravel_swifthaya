<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
  public function reviewer()
  {
    // use relationships later
    $user_id = Auth::user()->id;
    $reviews = Review::where("reviewer_id", $user_id)->get();
    return ReviewResource::collection($reviews);
  }
  public function reviewee()
  {
    // use relationships later
    $user_id = Auth::user()->id;
    $reviews = Review::where("reviewee_id", $user_id)->get();
    return ReviewResource::collection($reviews);
  }
  public function store(StoreReviewRequest $request)
  {
    $validated = $request->validated();

    $validated['reviewer_id'] = Auth::user()->id;
    $validated['reviewee_id'] = $request->reviewee_id;

    $review = Review::create($validated);

    return new ReviewResource($review);
  }
  public function update(StoreReviewRequest $request, Review $review)
  {
    Gate::authorize('update', $review);

    $validated = $request->validated();

    $review->update($validated);

    return new ReviewResource($review);
  }

  public function destroy(Review $review)
  {
    Gate::authorize('delete', $review);
    $review->delete();
    return response()->json(
      ["message" => "Review deleted successfully"]
    );
  }
}
