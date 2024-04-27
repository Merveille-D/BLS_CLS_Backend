<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\Alert\Alert;
use Carbon\Carbon;

if (!function_exists('sanitize_file_name')) {
    function sanitize_file_name($filename) : string {
        // Remove invalid characters (except alphanumeric, ., -, and _)
        $sanitized = preg_replace('/[^a-zA-Z0-9\.\_-]/', '_', $filename);

        $sanitized = trim($sanitized, ".-_");

        if (strlen($sanitized) > 255) {
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $sanitized = substr($sanitized, 0, 255 - strlen($extension) - 1) . '.' . $extension;
        }

        return $sanitized;
    }
}

if (!function_exists('api_response')) {
    function api_response(bool $success = true, string $message='', $data=[], $code=200) {
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data], $code);
    }
}

if (!function_exists('api_error')) {
    function api_error(bool $success = false, string $message='', $data=[], $code=500) {
        return response()->json(['success' => $success, 'message' => $message, 'errors' => $data], $code);
    }
}

if (!function_exists('generateReference')) {
    function generateReference($prefix, $length = 6)
    {
        $currentYear = date('Ymd');
        $randomPart = strtoupper(Str::random($length));
        $reference = $prefix . '-' . $currentYear .'-' . $randomPart;

        return $reference;
    }
}

if(!function_exists('uploadFile')) {
    function uploadFile($file, $path) {

        $name_file = date('Y-m-d_His-').Str::random(6).auth()->id().'-'.sanitize_file_name($file->getClientOriginalName());
        $file->storeAs($path, $name_file, 'public');

        $url = Storage::disk('public')->url('public/' . $path . '/' . $name_file);

        return $url;
    }
}

if(!function_exists('getFileName')) {
    function getFileName($file) {

        $name_file = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        return $name_file;
    }
}

if(!function_exists('searchElementIndice')) {
    function searchElementIndice($tableau, $indiceRecherche) {
        foreach ($tableau as $indice => $element) {
            if ($indice === $indiceRecherche) {
                return $element;
            }
            if (is_array($element)) {
                $resultat = searchElementIndice($element, $indiceRecherche);
                if ($resultat !== null) {
                    return $resultat;
                }
            }
        }
        return null;
    }
}

// function checkDealine($deadline) {
//     $now = Carbon::now();
//     $deadline = Carbon::parse($deadline);

//     return ($now->diffInDays($deadline) != 0) ? false : true;
// }

// function triggerAlert($subject, $message) {
//         $alert = new Alert();
//         $alert->title = $subject;
//         $alert->type = 'info';
//         $alert->message = $message;
//         $alert->trigger_at = Carbon::now()->addMinutes(1);

//         return $alert;
// }



function updateAlertTask($current_task, $next_task) {

    $alertsExist = $current_task->alerts()->exists();

    if ($alertsExist) {
        $alertsToDelete = $current_task->alerts()->whereNotIn('deadline', [$current_task->deadline])->get();

        if ($alertsToDelete->isEmpty()) {

            $alertsToDelete->each->delete();

            $days = diffInDays($current_task->deadline, ($next_task->deadline ?? $current_task->deadline->addDays(10) ));
            createAlert($current_task, $days);
        }
    } else {
        $days = diffInDays($current_task->deadline,  ($next_task->deadline ?? $current_task->deadline->addDays(10) ));
        createAlert($current_task, $days);
    }

    return $current_task;
}

function createAlert($current_task, $days) {
    $deadline = $deadline = Carbon::parse($current_task->deadline);
    $deadlines = [
        $deadline->addDays(0.20 * $days),
        $deadline->addDays(0.60 * $days),
        $deadline->addDays(0.95 * $days),
    ];

    $priorities = ['info', 'warning', 'urgent'];

    foreach ($deadlines as $index => $deadline) {
        $current_task->alerts()->create([
            'title' => $current_task->title,
            'deadline' => $current_task->deadline,
            'message' => $current_task->libelle,
            'priority' => $priorities[$index],
            'type' =>  $current_task->type,
            // 'trigger_at' => $deadline,
            'trigger_at' => Carbon::now(),
        ]);
    }
}

function diffInDays($date1, $date2) {
    $deadline = Carbon::parse($date1);
    $nextDeadline = Carbon::parse($date2);
    $days = $deadline->diffInDays($nextDeadline);

    return $days;
}





