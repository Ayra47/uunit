<?php

namespace App\Http\Controllers;

use App\Events\FrontWebsocket;
use App\Services\MlService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MlController extends Controller
{
    public MlService $service;
    
    public function __construct()
    {
        $this->service = new MlService;
    }
    
    public function getInfo(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'folder_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'errors' => $validator->errors()->toArray(),
            ]);
        }

        return response()->json([
            'success' => 1,
            'data' => $this->service->getInfo($request),
        ]);
    }

    public function sendMessage(Request $request)
    {
        FrontWebsocket::dispatch([
            "file_name" => $request['file_name'],
            "message" => $request['message'] ?? "no message",
        ]);
    }
}
