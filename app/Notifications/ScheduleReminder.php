<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ScheduleReminder extends Notification
{
    use Queueable;

    protected $schedule;
    protected $daysUntil;

    public function __construct($schedule, $daysUntil)
    {
        $this->schedule = $schedule;
        $this->daysUntil = $daysUntil;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Upcoming Schedule Reminder')
            ->line("Reminder: You have a schedule in {$this->daysUntil} days.")
            ->line("Date: " . $this->schedule->schedule_date->format('Y-m-d'))
            ->action('View Schedule', route('schedules.index'));
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Reminder: You have a schedule in {$this->daysUntil} days.",
            'schedule_id' => $this->schedule->id,
            'date' => $this->schedule->schedule_date->format('Y-m-d'),
        ];
    }
}