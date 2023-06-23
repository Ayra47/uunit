<?php

namespace App\Http\Controllers;

use App\Helpers\TgBotHelper;
use Illuminate\Http\Request;

class TgController extends Controller
{
    public function sendErrors(Request $request)
    {
        TgBotHelper::errors($request['error']);

        return response()->json([
            'success' => 1,
            'message' => "Ошибка отправлена"
        ]);
    }
}
