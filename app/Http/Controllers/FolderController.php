<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FileError;
use App\Models\Folder;
use Illuminate\Http\Request;
use App\Services\FolderService;
use Illuminate\Support\Facades\Validator;
use WeStacks\TeleBot\Laravel\TeleBot;

class FolderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    public function createFolder(Request $request)
    {
        $service = new FolderService;

        $result = $service->createFolder($request);

        TeleBot::sendMessage([
            "chat_id" => "-1001919078420",
            "text" => "Ваш файл завершил проверку"
        ]);

        return response()->json([
            'success' => 1,
            'data' => $result
        ]);
    }

    public function getFolders()
    {
        $model = Folder::paginate(5);

        return response()->json([
            'success' => 1,
            'data' => $model
        ]);
    }

    public function getFiles($id)
    {
        $model = File::where('folder_id', $id)->with('errors')->get();

        foreach ($model as $key => $item) {
            $last_slash_pos = strrpos($item->path, '/');
            if ($last_slash_pos !== false) {
                $new_string = substr($item->path, 0, $last_slash_pos);
                $item->path = $new_string; // Выведет "Test Small"
            }
        }

        return response()->json([
            'success' => 1,
            'data' => $model
        ]);
    }

    public function deleteError($id)
    {
        FileError::where("id", $id)->delete();
        
        return response()->json([
            'success' => 1,
            'message' => "Удалено"
        ]);
    }

    public function searchFolder(Request $request)
    {
        $text = $request['text'];
        $model = Folder::where("folder_name", "LIKE", "%$text%")->paginate(10);

        return response()->json([
            'success' => 1,
            'data' => $model
        ]);
    }
}
