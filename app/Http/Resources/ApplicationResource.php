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
          'applicant_id' => $this->applicant_id,
          'swifthayajob_id' => $this->swifthayajob_id,
          'project_id' => $this->project_id,
          'applied_at' => $this->applied_at,
        ];
    }
}
