<?php

namespace App\Notifications\Guarantee;

use App\Concerns\Traits\Guarantee\ConvHypothecNotificationTrait;
use App\Enums\ConvHypothecState;
use App\Mail\NotificationMail;
use App\Models\Guarantee\ConventionnalHypothecs\ConventionnalHypothec;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class ConvHypothecNextStep extends Notification implements ShouldQueue
{
    use Queueable, ConvHypothecNotificationTrait;

    /**
     * Create a new notification instance.
     */
    public function __construct(public ConventionnalHypothec $convHypo)
    {
        //
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
        $data = $this->nextStepBasedOnState($this->convHypo->state);
        return (new MailMessage)
                    ->subject($data['subject'])
                    ->line($data['message'])
                    ->action('Accéder à l\'application', url(env('FRONTEND_URL') ?? '/'))
                    ->line('merci d\'avoir choisir notre application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $data = $this->nextStepBasedOnState($this->convHypo->state);
        return [
            'title' => $data['subject'],
            'message' => $data['message'],
        ];
    }

    public function databaseType(object $notifiable): string
    {
        return 'conventionnal-hypothec';
    }
}
