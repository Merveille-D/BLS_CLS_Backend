<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FileUpload extends Model
{
    use HasFactory;

    public static function uploadFile($file, $path) {

        $name_file = $file->getClientOriginalName();
        $file->storeAs($path, $name_file, 'public');

        $url = Storage::disk('public')->url($path . '/' . $name_file);

        return $url;
    }
    
}
