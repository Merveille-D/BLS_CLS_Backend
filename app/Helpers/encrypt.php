<?php

//function that encrypts the string

use Illuminate\Support\Facades\Crypt;

if (! function_exists('encrypt')) {
    function encrypt(string $string): string
    {
        return Crypt::encryptString($string);
    }
}

//function that decrypts the string
if (! function_exists('decrypt')) {
    function decrypt(string $string): string
    {
        return Crypt::decryptString($string);
    }
}
