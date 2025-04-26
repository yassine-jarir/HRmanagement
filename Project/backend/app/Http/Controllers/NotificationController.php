<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotifications()
    {
         $notifications = Auth::user()->notifications;

        return response()->json($notifications);
    }
    public function markAsRead(Request $request, $notificationId)
    {
         $notification = Auth::user()->notifications()->find($notificationId);
    
        if ($notification) {
            $notification->markAsRead(); 
    
            return response()->json(['message' => 'Notification marked as read.']);
        }
    
        return response()->json(['message' => 'Notification not found.'], 404);
    }
}
