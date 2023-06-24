<?php

namespace App\Services;

use App\Models\File;
use App\Models\FileError;
use Illuminate\Http\Request;
use WeStacks\TeleBot\Laravel\TeleBot;

class MlService
{
    public function getInfo(Request $request)
    {
        foreach ($request['errors'] as $key => $item) {
            $file = File::where('path', $item['path'])->where('folder_id', $request['folder_id'])->first();
            FileError::create([
                'name' => $item['name'],
                'file_id' => $file->id,
                'page' => $item['page'],
                'description' => $item['description']
            ]);
        }

        TeleBot::bot("error_bot")->sendMessage([
            "chat_id" => "-1001951479143",
            "text" => "Ваш файл # " . $file->folder_id . ", имени: " . $file->folder->name . " завершил проверку",
        ]);
    }
}