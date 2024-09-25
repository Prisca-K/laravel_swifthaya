<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SwifthayajobResource extends JsonResource
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
      'company_id' => $this->company_id,
      'title' => $this->title,
      'description' => $this->description,
      'required_skills' => $this->required_skills,
      'location' => $this->location,
      'salary_range' => $this->salary_range,
      'job_type' => $this->job_type,
      'posted_at' => $this->posted_at->toDateTimeString(),
      'deadline_date' => (is_null($this->deadline_date)) ? $this->deadline_date : $this->deadline_date->toDateTimeString(),
      'status' => $this->status,
    ];
  }
}
