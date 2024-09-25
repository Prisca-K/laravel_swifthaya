<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
      'email' => $this->email,
      'user_type' => $this->user_type,
      'status' => $this->status,
      // 'last_login_at' => $this->last_login_at,
      'created_at' => $this->created_at->toDateTimeString(),
      "userprofile" => [
        'id' => $this->userprofile->id,
        'user_id' => $this->userprofile->user_id,
        'first_name' => ucfirst($this->userprofile->first_name),
        'last_name' => ucfirst($this->userprofile->last_name),
        'profile_picture' => $this->userprofile->profile_picture,
        'bio' => $this->userprofile->bio,
        'location' => $this->userprofile->location,
        'phone_number' => $this->userprofile->phone_number,
        'website' => $this->userprofile->website
      ]
    ];
  }
}
