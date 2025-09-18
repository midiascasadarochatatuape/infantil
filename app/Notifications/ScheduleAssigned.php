<?php

namespace App\Notifications;

use App\Models\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ScheduleAssigned extends Notification
{
    use Queueable;

    protected $schedule;

    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Schedule Assignment')
            ->line('You have been scheduled for ' . $this->schedule->schedule_date->format('Y-m-d'))
            ->line('Notes: ' . ($this->schedule->notes ?? 'No notes'))
            ->action('View Schedule', route('schedules.index'));
    }

    public function toArray($notifiable)
    {
        return [
            'schedule_id' => $this->schedule->id,
            'date' => $this->schedule->schedule_date->format('Y-m-d'),
            'notes' => $this->schedule->notes,
        ];
    }
}