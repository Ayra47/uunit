<?php

namespace App\Http\Controllers;

use App\Helpers\ClientIp;
use App\Helpers\TgBotHelper;
use Illuminate\Http\Request;
use WeStacks\TeleBot\Laravel\TeleBot;

class TgController extends Controller
{
    public function sendErrors(Request $request)
    {
        $currentDate = date('Y-m-d');
        $url = request()->fullUrl();
        $ua = request()->userAgent();
        $ip = ClientIp::_get_client_ip();
        $msg = "[{$currentDate}] \n{$url}\n{$request['message']}\n$ua\nip:{$ip}\n";

        TeleBot::bot("error_bot")->sendMessage([
            "chat_id" => "-1001951479143",
            "text" => $msg
        ]);

        return response()->json([
            'success' => 1,
            'message' => "Ошибка отправлена"
        ]);
    }
}
