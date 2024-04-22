<?php
use Illuminate\Support\Str;

if (!function_exists('format_file_path')) {
    function format_file_path($path) {
        $url = env('APP_URL').'/storage/'.$path;

        return $url;
    }
}

if (!function_exists('storeFile')) {
    function storeFile($file, $path = '') {
        if($file) {
            $sanitized_file_name = date('Y-m-d_His-').Str::random(6).auth()->id().'-'.sanitize_file_name($file->getClientOriginalName());

            $path = $file->storeAs($path, $sanitized_file_name, 'public');
            return 'public/' . $path;
        }
    }
}
