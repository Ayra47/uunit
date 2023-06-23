<?php

namespace App\Http\Controllers;

use App\Http\Service\FolderService;
use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FolderController extends Controller
{
    public FolderService $service;

    public function createFolder(Request $request)
    {
        $this->service = new FolderService;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'file' => 'required|file'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'errors' => $validator->errors()->toArray(),
            ]);
        }

        $result = $this->service->createFolder($request);

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
