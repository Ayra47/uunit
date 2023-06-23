<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use App\Services\FolderService;

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
        $model = File::where('folder_id', $request['folder_id'])->with('errors')->get();

        return response()->json([
            'success' => 1,
            'data' => $model
        ]);
    }
}
