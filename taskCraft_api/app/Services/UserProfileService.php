<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserProfile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Updates the main user profile data based on the provided request data.
     *
     * @param Request $request The HTTP request object containing the user profile data.
     * @param User $user The user object whose profile needs to be updated.
     * @throws Exception
     */
    public function updateMainUserProfile(Request $request, User $user)
    {
        if ($request->input('name')) {
            $user->name = $request->input('name');
            $user->save();
        }

        $userProfile = $user->profile;
        if (!$user->profile) {
            throw new Exception('Invalid User Profile');
        }

        if ($request->input('jobPosition')) {
            $userProfile->job_position = $request->input('jobPosition');
            $userProfile->save();
        }

        if ($request->hasFile('profilePicture')) {
            $image = $request->file('profilePicture');
            $path = $image->store('profile_pictures', 'public');

            if ($userProfile->profile_picture) {
                Storage::disk('public')->delete($userProfile->profile_picture);
            }

            $userProfile->profile_picture = $path;
            $userProfile->save();
        }

        $userProfile->refresh();
        return $userProfile;
    }
}
