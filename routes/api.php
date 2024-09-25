<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\CategoryController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;




// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-email', [AuthController::class, 'verifyOtp']);

Route::post('/login', [AuthController::class, 'login']);


Route::post('/password/forgot', [AuthController::class, 'forgotPassword']);
Route::post('/password/verify', [AuthController::class, 'verifyResetCode']);
Route::post('/password/reset', [AuthController::class, 'resetPassword']);



// Protected routes
Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // User Routes
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/user/update', [AuthController::class, 'updateProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    // Item Routes
    Route::get('/items', [ItemController::class, 'index']);
    Route::post('/items', [ItemController::class, 'store']);
    Route::get('/items/{item}', [ItemController::class, 'show']);
    Route::put('/items/{item}', [ItemController::class, 'update']);
    Route::delete('/items/{item}', [ItemController::class, 'destroy']);

    // Category Routes
    Route::get('/categories', [CategoryController::class, 'index']);

    // Chat Routes
    Route::get('/chats', [ChatController::class, 'index']);
    Route::post('/chats', [ChatController::class, 'store']);
    Route::get('/chats/{chat}', [ChatController::class, 'show']);

    // Message Routes
    Route::post('/chats/{chat_id}/messages', [MessageController::class, 'store']);
    Route::get('/chats/{chat_id}/messages', [MessageController::class, 'index']);

    // Favorites Routes
    Route::post('/favorites', [FavoriteController::class, 'store']);
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy']);

    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index']);
});


// Route for email verification
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return response()->json(['message' => 'Email verified successfully!']);
})->middleware(['auth', 'signed'])->name('verification.verify');

// Resend verification email
Route::post('/email/resend', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return response()->json(['message' => 'Email already verified.'], 400);
    }

    $request->user()->sendEmailVerificationNotification();

    return response()->json(['message' => 'Verification link resent!']);
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//test mailing service
use Illuminate\Support\Facades\Mail;

Route::get('/send-test-email', function () {
    Mail::raw('This is a test email from your Laravel app.', function ($message) {
        $message->to('test@example.com')
            ->subject('Test Email');
    });

    return 'Test email sent successfully!';
});
