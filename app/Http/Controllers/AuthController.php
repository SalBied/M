<?php
namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // Register a new user
    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->authService->register($request->validated());
            return response()->json(['message' => 'Registration successful! Please check your email for verification.'], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // Login a user
    public function login(LoginRequest $request)
    {
        try {
            $token = $this->authService->login($request->validated());
            return response()->json(['token' => $token], 200);
        } catch (UnauthorizedHttpException $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // Logout a user

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
    // Handle forgot password

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $this->authService->forgotPassword($request->validated());
            return response()->json(['message' => 'Reset link sent to your email.'], 200);
        } catch (ValidationException|Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    // Handle password reset

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        try {
            $this->authService->resetPassword($request->validated());
            return response()->json(['message' => 'Password reset successfully.'], 200);
        } catch (ValidationException|Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // Get authenticated user
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
}
