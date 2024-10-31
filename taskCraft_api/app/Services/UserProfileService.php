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

    /**
     * Updates the general user info profile based on the provided request data.
     *
     * @param Request $request The request object containing the user's updated information.
     * @param User $user The user whose profile needs to be updated.
     * @throws Exception
     */
    public function updateGeneralUserInfoProfile(Request $request, User $user): UserProfile
    {
        $profile = $user->profile;

        if (!$profile) {
            throw new Exception('Invalid user profile');
        }

        if ($request->input('bio')) {
            $profile->bio = $request->input('bio');
        }

        if ($request->input('uiMode')) {
            $profile->ui_mode = $request->input('uiMode');
        }

        if ($request->input('language')) {
            $profile->language = $request->input('language');
        }

        if ($request->input('timezone')) {
            $profile->timezone = $request->input('timezone');
        }

        $profile->save();
        $profile->refresh();
        return $profile;
    }
}
