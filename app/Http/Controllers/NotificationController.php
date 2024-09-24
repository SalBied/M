<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    // Get all notifications for the user
    public function index()
    {
        return response()->json($this->notificationService->getUserNotifications());
    }
}
