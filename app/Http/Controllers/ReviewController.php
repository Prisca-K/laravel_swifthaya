<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{

  public function create($revieweeId)
  {
    return view('reviews.create', compact('revieweeId'));
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'rating' => 'required|integer|min:1|max:5',
      'comment' => 'required|string|max:1000',
    ]);
    // dd($validated);

    $review = Review::create([
      'reviewer_id' => auth()->id(),
      'reviewee_id' => $request->reviewee_id,
      // 'job_id' => $request->job_id,
      // 'project_id' => $request->project_id,
      'rating' => $request->rating,
      'comment' => $request->comment,
    ]);
    dd($review);
    return redirect()->route('reviews.index', ['user' => $request->reviewee_id])->with('success', 'Review added successfully!');
  }

  public function edit(Review $review)
  {
    Gate::authorize('update', $review);
    return view('reviews.edit', compact('review'));
  }

  public function update(Request $request, Review $review)
  {
    Gate::authorize('update', $review);

    $request->validate([
      'rating' => 'required|integer|min:1|max:5',
      'content' => 'required|string|max:1000',
    ]);

    $review->update([
      'rating' => $request->rating,
      'content' => $request->content,
    ]);

    return redirect()->route('reviews.index', ['user' => $review->reviewee_id])->with('success', 'Review updated successfully!');
  }

  public function destroy(Review $review)
  {
    Gate::authorize('delete', $review);
    $review->delete();
    return back()->with('success', 'Review deleted successfully!');
  }
}
