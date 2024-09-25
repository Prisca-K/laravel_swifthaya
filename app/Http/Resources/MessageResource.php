<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
          "conversation_id" => $this->conversation_id,
          "sender_id" => $this->sender_id,
          "recipient_id" => $this->recipient_id,
          "content" => $this->content,
          "sent_at" => $this->sent_at->toDateTimeString(),
          'read_at' => (is_null($this->read_at)) ? $this->read_at : $this->read_at->toDateTimeString(),
        ];
    }
}
