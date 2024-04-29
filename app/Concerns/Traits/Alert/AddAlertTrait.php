<?php
namespace App\Concerns\Traits\Alert;

use App\Models\Alert\Alert;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

trait AddAlertTrait
{
    public function new_alert(Model $model, string $title, $message, string $type, $trigger_at, string $priority) : void {

        $alert = new Alert();
        $alert->title = $title;
        $alert->type = $type;
        $alert->priority =  $priority;
        $alert->deadline = now()->addDays(10);
        $alert->message = $message;
        $alert->trigger_at = env('EMAIL_SENDING_MODE') == 'test' ? Carbon::now()->addMinute() :  $trigger_at;
        $model->alerts()->save($alert);
    }
}
