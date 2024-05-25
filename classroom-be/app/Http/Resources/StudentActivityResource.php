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
            'details' => UserResource::make($this->user),
            'student_id' => $this->uuid,
            'grade' => GradeResource::make($this->grade),
            'activities' => ActivityResource::collection($this->activities),
        ];
    }
}
