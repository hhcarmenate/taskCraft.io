<?php

namespace App\Http\Resources;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BoardListResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'position' => $this->position,
            'tasks' => TaskResource::collection($this->orderByPosition())
        ];
    }

    /**
     * Orders the tasks by their position attribute in ascending order.
     *
     * This method sorts the*/
    private function orderByPosition()
    {
        return $this->tasks->sortBy('position');
    }
}
