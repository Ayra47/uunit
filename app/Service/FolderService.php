<?php

namespace App\Http\Service;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use ZipArchive;
use Illuminate\Support\Facades\Storage;

class FolderService
{
    public function createFolder(Request $request)
    {
        $file = $request->file('file');

        $path = $file->store('archives', 'local');

        $folder = Folder::create([
            'name' => $request['name'],
            'user_id' => auth()->id(),
            'folder_name' => '',
            'path' => $path,
        ]);

        $zip = new ZipArchive;
        $zip->open($file);

        $folder_name = 'archives/' . time();
        Storage::makeDirectory($folder_name);

        $zip->extractTo(storage_path('app/' . $folder_name));

        // Получите список всех файлов в папке
        $files = Storage::allFiles($folder_name);

        foreach ($files as $key => $path) {
            File::create([
                'folder_id' => $folder->id,
                'name' => $file->getClientOriginalName(),
                'path' => $path,
            ]);
        }

        // делаю запрос на бэк к Диме

        return 'Юху ошибки нет';
    }

    protected function sendFile()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'http://www.example.com/user/create', [
            'form_params' => [
                'email' => 'test@gmail.com',
                'name' => 'Test user',
                'password' => 'testpassword',
            ]
        ]);
    }
}
