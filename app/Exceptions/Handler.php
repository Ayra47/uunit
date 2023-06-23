<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Helpers\ClientIp;
use WeStacks\TeleBot\Laravel\TeleBot;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $e)
    {
        $message = $e->getMessage();
        $currentDate = date('Y-m-d');
        $url = request()->fullUrl();
        $ua = request()->userAgent();
        $ip = ClientIp::_get_client_ip();
        $msg = "[{$currentDate}] \n{$url}\n{$message}\n$ua\nip:{$ip}\n";

        TeleBot::bot("error_bot")->sendMessage([
            "chat_id" => "-1001951479143",
            "text" => $msg
        ]);
    }


    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
