<?php

namespace App\Notifications;

use App\Models\Alert\Alert;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AlertNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Alert $alert)
    {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        return (new MailMessage)
                    ->from('afrikskills@gmail.com', 'BLS')
                    ->greeting('Bonjour!')
                    ->subject($this->alert->title)
                    ->line($this->alert->message)
                    ->line('Délai : '. $this->alert->deadline ?? null)
                    // ->action('Notification Action', url('/'))
                    ->line('Merci de faire diligence!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->alert->title,
            'message' => $this->alert->message,
            'alert_id'=> $this->alert->id,
        ];
    }

    public function databaseType(object $notifiable): string
    {
        return $this->alert->type ?? 'alert';
    }
}
