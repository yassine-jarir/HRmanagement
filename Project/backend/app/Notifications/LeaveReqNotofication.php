<?php

namespace App\Notifications;

use App\Models\leaveReq;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class LeaveReqNotofication extends Notification
{
    use Queueable;
protected $LeaveReq;
    /**
     * Create a new notification instance.
     */
    public function __construct(leaveReq $leaveReq)
    {
        $this->LeaveReq = $leaveReq;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['Database'];
    }

    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'leave_request' => $this->LeaveReq->reason,
            'leave_type' => $this->LeaveReq->type,
            'user_name' => Auth::user()->name,
        ]);
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
