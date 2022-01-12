<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\SaveProfileRequest;
use App\Repositories\User\UserRepository;
use Illuminate\Http\JsonResponse;
use Throwable;

class ProfileController extends ApiController
{
    private UserRepository $repository;

    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    /**
     * Update User's profile
     * @param SaveProfileRequest $request
     * @return JsonResponse
     */
    public function update(SaveProfileRequest $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $user = $this->repository->updateProfile($user, $request);

            return response()->json(['user' => $user]);
        } catch (Throwable $exception) {
            $this->errorLog($exception, 'api');

            return $this->failResponse($exception->getMessage());
        }
    }

    /**
     * User Password Update.
     *
     * @return JsonResponse
     */
    public function passwordUpdate(): JsonResponse
    {
        //
    }

    /**
     * @return JsonResponse
     */
    public function emailUpdate(): JsonResponse
    {
        //
    }
}
