<?php

namespace App\Http\Controllers;

use App\Http\Service\FolderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FolderController extends Controller
{
    public FolderService $service;

    public function __construct()
    {
        $this->service = new FolderService;
    }

    public function createFolder(Request $request)
    {
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
}
