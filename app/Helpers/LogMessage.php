<?php

namespace App\Helpers;

use Log;

class LogMessage extends Log
{
    public static function __callStatic($method, $args)
    {
        if (!app()->isProduction()) {
            parent::__callStatic($method, $args);
        }
    }
}
