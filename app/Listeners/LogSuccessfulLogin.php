<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login $event
     * @return void
     */
    public function handle(Login $event)
    {
        $bubble = false;

        // create a log channel
        $log = new Logger('Authentication');
        //$log->pushHandler(new StreamHandler(storage_path("/logs/laravel_info.log"), Logger::INFO, $bubble));

        // add records to the log
        $user = $event->user ;

        if(isset($user['guard']) && $user['guard'] == 'admin') {
            $log->pushHandler(new StreamHandler(storage_path("/logs/laravel_warning.log"), Logger::WARNING, $bubble));
            $log->warning($user ['attributes']['email'] . ' was Login via Admin');
        } else {
            $log->pushHandler(new StreamHandler(storage_path("/logs/laravel_info.log"), Logger::INFO, $bubble));
            $log->info($user ['attributes']['email'] . ' was Login via User');
        }
        //$var_str = var_export($event->user, true);
        //$log->warning($var_str);
    }
}
