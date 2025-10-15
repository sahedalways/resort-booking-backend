<?php

namespace App\Http\Controllers\API;


use App\Http\Requests\Profile\AvatarRequest;
use App\Http\Requests\Profile\ChangePasswordRequest;
use App\Http\Requests\Profile\ProfileUpdateRequest as ProfileProfileUpdateRequest;
use App\Services\API\Profile\ProfileService;
use Illuminate\Http\Request;

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



    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $validated = $request->validated();
            $user = auth()->user();
            $updated = $this->profileService->changePassword($user, $validated);

            if ($updated) {

                return $this->sendResponse([], 'Password updated successfully');
            }

            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect',
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function getProfileOverview(Request $request)
    {
        try {
            $user = $request->user();

            $data = $this->profileService->getProfileOverview($user);

            return $this->sendResponse($data, 'Profile overview fetched successfully.');
        } catch (\Throwable $e) {
            return $this->sendError(
                'Something went wrong.',
                [
                    'exception' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile(),
                ],
                500
            );
        }
    }
}
