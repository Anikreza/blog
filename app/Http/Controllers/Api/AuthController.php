<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ForgotPasswordRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Requests\Api\TokenVerificationRequest;
use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Auth;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Notification;
use Throwable;

class AuthController extends ApiController
{
    /**
     * Login user and create token
     * Checks if credentials are fine and if user is allowed to login to the system
     *
     * @param LoginRequest $request
     * @return JsonResponse [string] access_token
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = [
            'email' => request('email'),
            'password' => request('password'),
        ];

        $user = Auth::attempt($credentials);

        if (!$user || (isset($user->status) && !$user->status)) {
            return response()->json([
                'code' => 401,
                'message' => 'invalid_credentials.'
            ], 401);
        }

        $tokenResult = $request->user()->createToken('auth:token');
        $user = auth()->user();

        return response()->json([
            'user' => $user,
            'access_token' => $tokenResult->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return JsonResponse [string] message
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'logged_out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @param Request $request
     * @return JsonResponse [json] user object
     */
    public function user(Request $request): JsonResponse
    {
        $user = auth()->user();
        return response()->json($user);
    }

    /**
     * Creates PIN and sends to users email address
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     * @throws Throwable
     */

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            $exists = User::where('email', $request->input('email'))->first();

            if (!$exists) {
                return $this->failResponse(422, 'email_does_not_exists');
            }

            DB::beginTransaction();
            $token = rand(100000, 999999);
            PasswordReset::updateOrCreate(['email' => $request->input('email')], ['token' => $token, 'created_at' => now()]);
            Notification::route('mail', $request->input('email'))->notify(new ResetPasswordNotification($token));
            DB::commit();

            return $this->successResponse(['message' => 'email_sent']);
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->errorLog($exception, 'api');

            return $this->failResponse($exception->getMessage());
        }
    }

    /**
     * @param TokenVerificationRequest $request
     * @return JsonResponse
     * @throws Throwable
     */

    public function tokenVerification(TokenVerificationRequest $request): JsonResponse
    {
        try {
            $exists = PasswordReset::where('token', $request->input('token'))->where('email', $request->input('email'))->first();

            if (!$exists || (isset($exists->expired) && $exists->expired)) {
                return $this->failResponse(422, 'invalid_pin');
            }

            return $this->successResponse(['data' => ['email' => $exists->email]]);
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->errorLog($exception, 'api');

            return $this->failResponse($exception->getMessage());
        }
    }

    /**
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     * @throws Throwable
     */

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $employee = User::where('email', $request->input('email'))->first();

            if ($employee) {
                $employee->update(['password' => bcrypt($request->input('password'))]);
                DB::commit();

                return $this->successResponse(['message' => 'password_updated']);
            } else {
                return $this->failResponse(422, 'invalid_email');
            }

        } catch (\Exception $exception) {
            DB::rollBack();
            $this->errorLog($exception, 'api');

            return $this->failResponse($exception->getMessage());
        }
    }
}
