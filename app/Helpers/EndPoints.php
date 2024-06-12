<?php

namespace App\Helpers;

class EndPoints
{
    public static function getBaseUrl()
    {
        return config('services.api.base_url');
    }
}
