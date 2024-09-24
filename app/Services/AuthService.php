<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthService
{
    public function register(array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'location' => $data['location'],
        ]);

        // Send email verification link
        event(new Registered($user));

        return $user;
    }

    public function login(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new UnauthorizedHttpException('Basic', 'Invalid credentials provided.');
        }

        // Create token
        return $user->createToken('auth_token')->plainTextToken;
    }

    /**
     * @throws ValidationException
     */
    public function forgotPassword(array $data)
    {
        $status = Password::sendResetLink($data);

        // Check if the reset link was sent
        if ($status !== Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'email' => ['Unable to send reset link.'],
            ]);
        }

        return $status;
    }

    /**
     * @throws ValidationException
     */
    public function resetPassword(array $data)
    {
        $status = Password::reset($data, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        // Check if the password was successfully reset
        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => ['Unable to reset password.'],
            ]);
        }

        return $status;
    }
}
