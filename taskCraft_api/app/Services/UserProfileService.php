<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserProfile;

class UserProfileService
{
    public function getOrCreateUserProfile(User $user)
    {
        $userProfile = $user->profile;

        if ($userProfile) {
            return $userProfile;
        }

        return $this->createMinimalProfile($user);
    }

    public function createMinimalProfile(User $user)
    {
        return UserProfile::query()->create([
            'user_id' => $user->id
        ]);
    }
}
