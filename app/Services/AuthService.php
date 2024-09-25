<?php

namespace App\Services;

use App\Mail\RegistrationOtpMail;
use App\Mail\ResetPasswordCode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected $otpExpiryMinutes = 15;

    public function register(array $data): User
    {
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'location' => $data['location'],
            'profile_picture' => $data['profile_picture'] ?? null,
            'email_verified_at' => null,  // Mark as unverified
            'role' => 'user',
            'total_items_sold' => 0,
            'feedback_rating' => 0,
        ]);

        // Generate and send OTP
        $this->sendOtp($user->email, new RegistrationOtpMail($this->generateOtp($user->email)));

        return $user;
    }

    public function verifyOtp(array $data)
    {
        $otpEntry = $this->getOtpEntry($data['email'], $data['otp']);

        if (!$otpEntry) {
            throw ValidationException::withMessages(['otp' => 'Invalid OTP code.']);
        }

        if ($this->isOtpExpired($otpEntry->created_at)) {
            return response()->json(['message' => 'OTP has expired.'], 400);
        }

        // Verify the user’s email
        $user = User::where('email', $data['email'])->firstOrFail();
        $user->email_verified_at = Carbon::now();
        $user->save();

        // Clean up OTP entry
        $this->clearOtp($data['email']);

        return $user;
    }

    public function forgotPassword(array $data)
    {
        $user = $this->getUserByEmail($data['email']);

        // Generate and send OTP for password reset
        $this->sendOtp($user->email, new ResetPasswordCode($this->generateOtp($user->email)));

        return $user;
    }

    public function verifyResetCode(array $data)
    {
        $otpEntry = $this->getOtpEntry($data['email'], $data['code']);

        if (!$otpEntry) {
            throw ValidationException::withMessages(['code' => 'Invalid or expired reset code.']);
        }

        if ($this->isOtpExpired($otpEntry->created_at)) {
            return response()->json(['message' => 'Reset code has expired.'], 400);
        }

        // Generate a temporary reset token
        $resetToken = $this->generateResetToken($data['email']);

        return ['reset_token' => $resetToken];
    }

    public function resetPassword(array $data)
    {

        $resetEntry = $this->getResetTokenEntry($data['reset_token']);

       if (!$resetEntry) {
            throw ValidationException::withMessages(['reset_token' => 'Invalid or expired reset token.']);
        }

        $user = User::where('email', $resetEntry->email)->firstOrFail();

        // Update password
        $user->password = Hash::make($data['password']);
        $user->save();

        // Clean up the password reset entry
        $this->clearResetToken($user->email);

        return $user;
    }

    public function login(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            throw ValidationException::withMessages(['email' => 'No account found for this email address.']);
        }

        if (is_null($user->email_verified_at)) {
            throw ValidationException::withMessages(['email' => 'Your email is not verified.']);
        }

        if (!Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages(['password' => 'Incorrect password.']);
        }

        // Generate an access token
        return $user->createToken('auth_token')->plainTextToken;
    }

    // Private helper methods to keep code DRY

    private function sendOtp(string $email, $mailable): void
    {
        Mail::to($email)->send($mailable);
    }

    private function generateOtp(string $email): string
    {
        $otpCode = rand(100000, 999999);
        DB::table('user_otps')->updateOrInsert(
            ['email' => $email],
            ['otp' => $otpCode, 'created_at' => Carbon::now()]
        );
        return $otpCode;
    }

    private function generateResetToken(string $email): string
    {
        $resetToken = Str::random(64);
        DB::table('password_resets')
            ->updateOrInsert(
                ['email' => $email],
                ['reset_token' => $resetToken, 'reset_token_expires_at' => Carbon::now()->addMinutes($this->otpExpiryMinutes)]
            );
        return $resetToken;
    }

    private function getOtpEntry(string $email, string $otp)
    {
        return DB::table('user_otps')
            ->where('email', $email)
            ->where('otp', $otp)
            ->first();
    }

    private function getResetTokenEntry(string $resetToken)
    {
        return DB::table('password_resets')
            ->where('reset_token', $resetToken)
            ->where('reset_token_expires_at', '>=', Carbon::now())
            ->first();
    }

    private function isOtpExpired(string $createdAt): bool
    {
        return Carbon::parse($createdAt)->addMinutes($this->otpExpiryMinutes)->isPast();
    }

    private function clearOtp(string $email): void
    {
        DB::table('user_otps')->where('email', $email)->delete();
    }

    private function clearResetToken(string $email): void
    {
        DB::table('password_resets')->where('email', $email)->delete();
    }

    private function getUserByEmail(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }
}
