<?php

namespace App\Helpers;

class Log
{
    public static function logError($message)
    {
        $logFile = "debug.log";
        if (isset($message)) {
            error_log($message .' : '.date('Y-m-d H:i:s'). "\n", 3, $logFile);
        }
    }
}
