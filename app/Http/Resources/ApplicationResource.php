<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
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
          'job_title' => $this->job_title,
          'applicant_id' => $this->applicant_id,
          'swifthayajob_id' => $this->swifthayajob_id,
          'project_id' => $this->project_id,
          'cover_letter' => $this->cover_letter,
          'attachments' => $this->attachments, 
          'applied_at' => $this->applied_at,
        ];
    }
}
