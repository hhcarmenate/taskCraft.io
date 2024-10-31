<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserProfileResource;
use App\Http\Traits\FailResponseTrait;
use App\Models\User;
use App\Services\UserProfileService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    /**
     * Updates the main profile of the user based on the provided request data.
     *
     * @param Request $request The request data containing the updated user profile information.
     * @param User $user The user entity whose main profile needs to be updated.
     *
     * @return UserProfileResource|JsonResponse Returns a UserProfileResource if the main profile is successfully updated,
     * or a JsonResponse with an error response if an exception occurs during the update process.
     */
    public function updateMainProfile(Request $request, User $user): UserProfileResource|JsonResponse
    {
        try {
            return UserProfileResource::make($this->userProfileService->updateMainUserProfile($request, $user));
        } catch (Exception $e) {
            return $this->genericFailResponse($e);
        }
    }

    /**
     * @param Request $request
     * @param User $user
     * @return UserProfileResource|JsonResponse
     */
    public function updateGeneralProfile(Request $request, User $user): UserProfileResource|JsonResponse
    {
        try {
            return UserProfileResource::make($this->userProfileService->updateGeneralUserInfoProfile($request, $user));
        } catch (Exception $e) {
            return $this->genericFailResponse($e);
        }
    }

}
