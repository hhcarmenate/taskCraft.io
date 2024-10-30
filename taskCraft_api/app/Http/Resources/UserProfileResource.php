<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserProfileResource extends JsonResource
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
            'userId' => $this->user_id,
            'profilePicture' => $this->profile_picture ? config('app.app_url') . Storage::url($this->profile_picture)  : null,
            'phoneNumber' => $this->email,
            'birthDate' => $this->birth_date,
            'timezone' => $this->timezone,
            'language' => $this->language,
            'uiMode' => $this->ui_mode,
            'notificationPreferences' => $this->notification_preferences,
            'bio' => $this->bio,
            'jobPosition' => $this->job_position,
        ];
    }
}
