<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;

class EncryptHelper
{
    public static function encryptId($id)
    {
        return Crypt::encryptString($id);
    }

    public static function decryptId($encryptedId)
    {
        return Crypt::decryptString($encryptedId);
    }
}
