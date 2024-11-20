<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class TaskCommentResource extends JsonResource
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
            'task_id' => $this->task_id,
            'createdBy' => UserResource::make($this->createdBy),
            'comment' => $this->comment,
            'createdAt' => Carbon::parse($this->created_at)->format('M. j, Y'),
            'profilePicture' => $this->createdBy?->profile?->profile_picture
                ? config('app.app_url') . Storage::url($this->createdBy->profile->profile_picture) : null,
        ];
    }
}
