<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory;

    public static function uploadFile($file, $path) {

        $name_file = $file->getClientOriginalName();
        $file->storeAs($path, $name_file, 'public');

        return $name_file;
    }
}
