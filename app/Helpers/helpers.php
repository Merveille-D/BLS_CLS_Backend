<?php

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
    function api_response($success, $message='', $data=[], $code=200) {
        return response()->json(['success' => $success, 'message' => $message, 'data' => $data], $code);
    }
}


