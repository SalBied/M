<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Http\Requests\Auth\VerifyResetCodeRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // User registration
    public function register(RegisterRequest $request)
    {
        try {
            $this->authService->register($request->validated());
            return response()->json(['message' => 'Registration successful! Please check your email for verification.'], 201);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    // OTP verification for registration
    public function verifyOtp(VerifyOtpRequest $request)
    {
        try {
            $this->authService->verifyOtp($request->validated());
            return response()->json(['message' => 'OTP verified successfully.'], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    // User login
    public function login(LoginRequest $request)
    {
        try {
            $token = $this->authService->login($request->validated());
            return response()->json(['token' => $token], 200);
        } catch (UnauthorizedHttpException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    // User logout
    public function logout()
    {
        $user = Auth::user();
        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out successfully.'], 200);
        }

        return response()->json(['error' => 'No active session found.'], 400);
    }

    // Forgot password (send reset code)
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $this->authService->forgotPassword($request->validated());
            return response()->json(['message' => 'Reset code sent to your email.'], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);  // Proper validation error response
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    // Verify reset code
    public function verifyResetCode(VerifyResetCodeRequest $request)
    {
        try {
           $resetToken = $this->authService->verifyResetCode($request->validated())['reset_token'];

            return response()->json(['message' => 'Reset code verified successfully.' . $resetToken ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    // Reset password
    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $this->authService->resetPassword($request->validated());
            return response()->json(['message' => 'Password reset successfully.'], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    // Get authenticated user details
    public function getUser()
    {
        return response()->json(Auth::user());
    }

    // Update user profile
    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        $user->update($request->validated());
        return response()->json($user);
    }

    // Centralized error response for all exceptions
    private function errorResponse(Exception $e)
    {
        return response()->json(['error' => $e->getMessage()], 400);
    }
}
