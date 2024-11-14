<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'list_id' => $this->list_id,
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'created_by' => UserResource::make($this->createdBy),
            'assigned_to' => UserResource::make($this->assignedTo),
            'start_date' => $this->start_date,
            'due_date' => $this->due_date,
            'position' => $this->position
        ];
    }
}
