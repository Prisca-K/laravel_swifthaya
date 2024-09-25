<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      "id" => $this->id,
      "reviewer_id" => $this->reviewer_id,
      "reviewee_id" => $this->reviewee_id,
      "rating" => $this->rating,
      "comment" => $this->comment,
      'status' => $this->status,
    ];
  }
}
