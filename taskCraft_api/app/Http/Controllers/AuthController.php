<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login into the app.
     * @param LoginRequest $request
     * @return UserResource
     * @throws ValidationException
     */
    public function login(LoginRequest $request): UserResource
    {
        $user = User::query()
            ->where('email', $request->input('email'))
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Todo: add this features in futures iterations
        /*if (!$user->hasVerifiedEmail()) {
            throw ValidationException::withMessages([
                'email' => ['Your email address is not verified. Please verified your email!'],
            ]);
        }*/

        Auth::login($user);
        $request->session()->regenerate();
        return UserResource::make($user);
    }

    /**
     * Register a new user.
     * @throws ValidationException
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::query()->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['Invalid user credentials']
            ]);
        }

        return response()->json([
            'message' => 'Registration successful, please check your email for verification link'
        ]
        , 201);
    }
}
