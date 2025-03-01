<?php

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (! function_exists('sanitize_file_name')) {
    function sanitize_file_name($filename): string
    {
        // Remove invalid characters (except alphanumeric, ., -, and _)
        $sanitized = preg_replace('/[^a-zA-Z0-9\.\_-]/', '_', $filename);

        $sanitized = trim($sanitized, '.-_');

        if (strlen($sanitized) > 255) {
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $sanitized = substr($sanitized, 0, 255 - strlen($extension) - 1) . '.' . $extension;
        }

        return $sanitized;
    }
}

if (! function_exists('api_response')) {
    function api_response(bool $success = true, string $message = '', $data = [], $code = 200)
    {
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data], $code);
    }
}

if (! function_exists('api_error')) {
    function api_error(bool $success = false, string $message = '', $data = [], $code = 500)
    {
        return response()->json(['success' => $success, 'message' => $message, 'errors' => $data], $code);
    }
}

if (! function_exists('generateReference')) {
    function generateReference($prefix, Model $model)
    {
        $currentDate = date('YmdHis');
        $number = $model->withoutGlobalScopes()->count() + 1;
        $reference = $prefix . '-' . completeWithZeros($number) . '-' . $currentDate;

        return $reference;
    }
}

if (! function_exists('completeWithZeros')) {
    function completeWithZeros($number, $length = 4)
    {
        $numberStr = (string) $number;

        if (strlen($numberStr) < $length) {
            $nbZeros = $length - strlen($numberStr);

            // Ajouter les zéros à gauche
            $numberStr = str_repeat('0', $nbZeros) . $numberStr;
        }

        return $numberStr;
    }
}

if (! function_exists('uploadFile')) {
    function uploadFile($file, $path)
    {

        $name_file = date('Y-m-d_His-') . Str::random(6) . auth()->id() . '-' . sanitize_file_name($file->getClientOriginalName());
        $file->storeAs($path, $name_file, 'public');

        $url = Storage::disk('public')->url('public/' . $path . '/' . $name_file);

        return $url;
    }
}

if (! function_exists('getFileName')) {
    function getFileName($file)
    {

        $name_file = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        return $name_file;
    }
}

if (! function_exists('searchElementIndice')) {
    function searchElementIndice($tableau, $indiceRecherche)
    {
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

if (! function_exists('formatDateTime')) {
    function formatDateTime($dateTime, $locale = null)
    {
        if (in_array($dateTime, [null, 'null'])) {
            return '';
        }

        $locale = $locale ?: config('app.locale');

        $formatMap = [
            'fr' => 'DD/MM/YYYY à HH:mm', // French format
            'en' => 'MMMM D, YYYY h:mm A', // English format
        ];

        return Carbon::parse($dateTime)->locale($locale)->isoFormat($formatMap[$locale]);
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

if (! function_exists('convertNumberToLetter')) {
    function convertNumberToLetter($nombre)
    {
        $unites = ['zéro', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf'];
        $dizaines = ['', 'dix', 'vingt', 'trente', 'quarante', 'cinquante', 'soixante', 'soixante', 'quatre-vingt', 'quatre-vingt'];
        $specials = ['dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize', 'dix-sept', 'dix-huit', 'dix-neuf'];

        if ($nombre < 10) {
            return $unites[$nombre];
        } elseif ($nombre < 20) {
            return $specials[$nombre - 10];
        } elseif ($nombre < 100) {
            $dizaine = floor($nombre / 10);
            $unite = $nombre % 10;
            if ($unite == 0) {
                return $dizaines[$dizaine];
            } elseif ($dizaine == 7 || $dizaine == 9) {
                return $dizaines[$dizaine] . '-' . $specials[$unite];
            } else {
                return $dizaines[$dizaine] . '-' . $unites[$unite];
            }
        } elseif ($nombre < 1000) {
            $centaine = floor($nombre / 100);
            $reste = $nombre % 100;
            if ($centaine == 1) {
                return 'cent' . ($reste ? ' ' . convertNumberToLetter($reste) : '');
            } else {
                return $unites[$centaine] . ' cent' . ($reste ? ' ' . convertNumberToLetter($reste) : '');
            }
        } elseif ($nombre < 1000000) {
            $mille = floor($nombre / 1000);
            $reste = $nombre % 1000;
            if ($mille == 1) {
                return 'mille' . ($reste ? ' ' . convertNumberToLetter($reste) : '');
            } else {
                return convertNumberToLetter($mille) . ' mille' . ($reste ? ' ' . convertNumberToLetter($reste) : '');
            }
        } elseif ($nombre < 1000000000) {
            $million = floor($nombre / 1000000);
            $reste = $nombre % 1000000;
            if ($million == 1) {
                return 'un million' . ($reste ? ' ' . convertNumberToLetter($reste) : '');
            } else {
                return convertNumberToLetter($million) . ' millions' . ($reste ? ' ' . convertNumberToLetter($reste) : '');
            }
        } else {
            return $nombre; // Pour les très grands nombres non pris en charge ici
        }
    }

}
