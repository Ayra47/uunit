<?php

namespace App\Services;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use ZipArchive;
use Illuminate\Support\Facades\Storage;

class MlService
{
    public function getInfo(Request $request)
    {
        foreach ($request['errors'] as $key => $item) {
            
        }
    }
}