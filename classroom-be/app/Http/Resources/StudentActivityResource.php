<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'activity_id' => $this->activity_id,
            'name' => $this->activity->name,
            'score' => $this->score,
            'submitted_at' => $this->created_at->format('Y-m-d h:m:s')
        ];
    }
}
