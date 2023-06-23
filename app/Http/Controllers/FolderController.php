<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\FolderService;

class FolderController extends Controller
{
    public function createFolder(Request $request)
    {
        $service = new FolderService;

        $validator = Validator::make($request->all(), [
            'file' => 'required|file'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'errors' => $validator->errors()->toArray(),
            ]);
        }

        $result = $service->createFolder($request);

        return response()->json([
            'success' => 1,
            'data' => $result
        ]);
    }

    public function getFolders()
    {
        $model = Folder::paginate(20);

        return response()->json([
            'success' => 1,
            'data' => $model
        ]);
    }

    public function getFiles(Request $request)
    {
        $model = File::where('folder_id', $request['folder_id'])->with('errors')->get();

        return response()->json([
            'success' => 1,
            'data' => $model
        ]);
    }
}
