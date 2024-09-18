<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'user_id' => $this->user_id,
      'first_name' => ucfirst($this->first_name),
      'last_name' => ucfirst($this->last_name),
      'profile_picture' => $this->profile_picture,
      'bio' => $this->bio,
      'location' => $this->location,
      'phone_number' => $this->phone_number,
      'website' => $this->website,
    ];
  }
}
