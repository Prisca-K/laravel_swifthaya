<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
      'poster_id' => $this->poster_id,
      'title' => $this->title,
      'description' => $this->description,
      'required_skills' => $this->required_skills,
      'budget' => $this->budget,
      'duration' => $this->duration,
      'posted_at' => $this->posted_at,
      'deadline_date' => $this->posted_at,
    ];
  }
}
