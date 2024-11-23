<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WorkspaceResource extends JsonResource
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
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
            'logo' => $this->logo ? config('app.app_url') . Storage::url($this->logo)  : null,
            'boards' => BoardResource::collection($this->boards),
            'members' => UserResource::collection($this->members),
            'guest' => UserResource::collection($this->guests),
            'owner' => UserResource::make($this->owner->first())
        ];
    }
}
