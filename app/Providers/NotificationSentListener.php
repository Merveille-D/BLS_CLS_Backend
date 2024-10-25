<?php

namespace App\Providers;

use App\Models\Alert\Notification;
use Illuminate\Notifications\Events\NotificationSent;

class NotificationSentListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NotificationSent $event): void
    {
        $notif = Notification::find($event->notification->id);
        $notif->alert_id = $notif->data['alert_id'] ?? null;
        // $notif->priority = $notif->data['priority'] ?? null;
        $notif->save();
    }
}
