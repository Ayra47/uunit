<?php

namespace App\Http\Controllers;

use App\Events\FrontWebsocket;
use App\Models\File;
use App\Models\FileError;
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
        if ($request['id']) {
            $data = $request->toArray();

            // $file = File::where('name', $data['files'][0]['file_name'])->where('folder_id', $data['id'])->first();
            // $file->is_ready = 1;
            // $file->save();

            foreach ($data['files'] as $key => $item) {
                if ($item['description']) {
                    FileError::create([
                        'name' => $item['name'],
                        'file_id' => 10,
                        'page' => $item['page'] ?? 0,
                        'description' => $item['description'] ?? "no description"
                    ]);
                }
            }
        } else {
            $data = [
                'id' => 123,
                'files' => [
                    [
                        'file_name' => '1.pdf',
                        'folder' => '12',
                        'name' => 'Starts on 45',
                        'description' => 'Allowed differences:\n',
                        'page' => 1
                    ],
                    [
                        'file_name' => '1.pdf',
                        'folder' => '12',
                        'name' => 'Starts on 34',
                        'description' => 'Allowed differences:\n',
                        'page' => 3
                    ]
                ]
            ];
        }

        FrontWebsocket::dispatch($data);

        return 1;
    }
}
