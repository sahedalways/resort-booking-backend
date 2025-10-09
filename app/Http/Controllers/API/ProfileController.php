<?php

namespace App\Http\Controllers\API;


use App\Http\Requests\Profile\AvatarRequest;
use App\Http\Requests\Profile\ProfileUpdateRequest as ProfileProfileUpdateRequest;
use App\Services\API\Profile\ProfileService;


class ProfileController extends BaseController
{
    protected ProfileService $profileService;


    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }


    public function changeAvatar(AvatarRequest $request)
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return $this->sendError('Unauthorized', [], 401);
            }

            // 🔧 Service call
            $this->profileService->changeAvatar($user, $request->file('avatar'));


            $user->load('profile');

            return $this->sendResponse($user, 'Avatar updated successfully!');
        } catch (\Throwable $e) {
            return $this->sendError('Something went wrong.', [
                'exception' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], 500);
        }
    }



    public function profileDataUpdate(ProfileProfileUpdateRequest $request)
    {
        try {
            $validated = $request->validated();

            $updatedUser = $this->profileService->updateProfile(auth()->user(), $validated);

            $updatedUser->load('profile');

            return $this->sendResponse($updatedUser, 'Profile updated successfully!');
        } catch (\Throwable $e) {
            return $this->sendError('Something went wrong.', [
                'exception' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], 500);
        }
    }
}
