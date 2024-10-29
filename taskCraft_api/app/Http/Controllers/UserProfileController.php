<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserProfileResource;
use App\Http\Traits\FailResponseTrait;
use App\Models\User;
use App\Services\UserProfileService;
use Exception;
use Illuminate\Http\JsonResponse;

class UserProfileController extends Controller
{
    use FailResponseTrait;

    private UserProfileService $userProfileService;

    /**
     * Constructor for the MyClass class.
     *
     * @param UserProfileService $userProfileService The user profile service to be injected.
     *
     * @return void
     */
    public function __construct(UserProfileService $userProfileService)
    {
        $this->userProfileService = $userProfileService;
    }

    /**
     * Retrieve the user profile for a given User object.
     *
     * @param User $user The user for whom the profile needs to be retrieved.
     *
     * @return UserProfileResource|JsonResponse Returns UserProfileResource if successful, or a JsonResponse containing error message.
     */
    public function getUserProfile(User $user): UserProfileResource|JsonResponse
    {
        try {
            return UserProfileResource::make($this->userProfileService->getOrCreateUserProfile($user));
        } catch (Exception $e) {
            return $this->genericFailResponse($e);
        }
    }
}
