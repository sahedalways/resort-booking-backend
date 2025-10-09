<?php

namespace App\Http\Controllers\API;


use App\Http\Requests\Profile\AvatarRequest;
use App\Services\API\Profile\ProfileService;
use Illuminate\Http\JsonResponse;

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
}
