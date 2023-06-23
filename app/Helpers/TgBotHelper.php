<?php

namespace App\Helpers;
use Throwable;
use WeStacks\TeleBot\Laravel\TeleBot;

class TgBotHelper
{
    public static function errors($message)
    {
        $currentDate = date('Y-m-d');
        $url = request()->fullUrl();
        $ua = request()->userAgent();
        $ip = ClientIp::_get_client_ip();
        $msg = "[{$currentDate}] \n{$url}\n{$message}\n$ua\nip:{$ip}\n";

        TeleBot::bot("error_bot")->sendMessage([
            "chat_id" => "-1001953987218",
            "text" => $msg
        ]);
    }
}
