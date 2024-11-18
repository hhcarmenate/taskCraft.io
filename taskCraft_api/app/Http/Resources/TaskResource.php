<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

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
            'created_by' => $this->createdBy ? UserResource::make($this->createdBy) : null,
            'assigned_to' => $this->assignedTo ? UserResource::make($this->assignedTo) : null,
            'start_date' => $this->start_date ?  Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date)->format('m/d/Y') : null,
            'due_date' => $this->due_date ? Carbon::createFromFormat('Y-m-d H:i:s', $this->due_date)->format('m/d/Y') : null,
            'position' => $this->position
        ];
    }
}
