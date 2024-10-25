<?php

namespace App\Notifications\Guarantee;

use App\Models\Guarantee\ConventionnalHypothecs\ConventionnalHypothec;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class ConvHypothecInit extends Notification implements ShouldQueue
{
    use Queueable;

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
        return (new MailMessage)
            ->subject('Rappel : VERIFICATION DE LA PROPRIETE DE L\'IMMEUBLE')
            ->line('Ce message est un rappel pour compléter l\'étape de la vérification de la propriété de l\'immeuble')
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
            'title' => 'Rappel : VERIFICATION DE LA PROPRIETE DE L\'IMMEUBLE',
            'message' => 'Ce message est un rappel pour compléter l\'étape de la vérification de la propriété de l\'immeuble',
        ];
    }

    public function databaseType(object $notifiable): string
    {
        return 'conventionnal-hypothec';
    }
}
