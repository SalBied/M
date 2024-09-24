<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class NotificationService
{
    public function getUserNotifications()
    {
        return Auth::user()->notifications;  // Laravel’s built-in notifications relation
    }
}
