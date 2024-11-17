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
            'created_by' => UserResource::make($this->createdBy),
            'assigned_to' => UserResource::make($this->assignedTo),
            'start_date' =>  Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date)->format('m/d/Y'),
            'due_date' => Carbon::createFromFormat('Y-m-d H:i:s', $this->due_date)->format('m/d/Y'),
            'position' => $this->position
        ];
    }
}
