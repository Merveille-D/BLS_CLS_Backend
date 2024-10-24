<?php

namespace App\Concerns\Traits\Alert;

use App\Models\Alert\Alert;
use Carbon\Carbon;
use DateInterval;
use DateTimeImmutable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

trait AddAlertTrait
{
    public function new_alert(Model $model, string $title, $message, string $type, $trigger_at, string $priority, $deadline = null): void
    {

        $alert = new Alert;
        $alert->title = $title;
        $alert->type = $type;
        $alert->priority = $priority;
        $alert->deadline = $deadline ?? now()->addDays(10);
        $alert->message = $message;
        $alert->trigger_at = env('EMAIL_SENDING_MODE') == 'test' ? Carbon::now()/* ->addMinute() */ : $trigger_at;
        $model->alerts()->save($alert);
    }

    public function getMilestoneDates(DateTimeInterface $deadline): array
    {
        $today = new DateTimeImmutable;
        $interval = $deadline->diff($today);
        $totalDays = $interval->days;

        $percentages = [0.2, 0.6, 0.9, 1];
        $milestoneIntervals = array_map(
            fn ($percentage) => new DateInterval('P' . round($totalDays * $percentage) . 'D'),
            $percentages
        );

        $milestoneDates = array_map(fn ($interval) => $today->add($interval), $milestoneIntervals);

        return $milestoneDates;
    }
}
