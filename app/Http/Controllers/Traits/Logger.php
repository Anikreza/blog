<?php


namespace App\Http\Controllers\Traits;

use Log;

trait Logger
{
    public function errorLog($exception, $channel = false)
    {
        $message = 'File:' . $exception->getFile() . '<br> Line: ' . $exception->getLine() . '<br> Message: ' . $exception->getMessage();
        if ($channel && !is_null(Log::channel($channel))) {
            Log::channel($channel)->error($message);
        } else {
            Log::error($message);
        }
    }
}
