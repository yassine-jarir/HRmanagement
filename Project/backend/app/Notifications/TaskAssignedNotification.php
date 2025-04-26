<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Tasks;

class TaskAssignedNotification extends Notification
{
    use Queueable;

    protected $task;

    public function __construct(Tasks $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['database'];  
    }

    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'task_id' => $this->task->id,
            'task_name' => $this->task->task_name,
            'description' => $this->task->description,
            'user_id' => $notifiable->id,
        ]);
    }
}
