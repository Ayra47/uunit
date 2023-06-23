<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use App\Services\FolderService;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'folder_id' => 'required|exists:folder,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'errors' => $validator->errors()->toArray(),
            ]);
        }

        $model = File::where('folder_id', $request['folder_id'])->with('errors')->get();

        return response()->json([
            'success' => 1,
            'data' => $model
        ]);
    }
}
