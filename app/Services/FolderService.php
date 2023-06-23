<?php

namespace App\Services;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;
use ZipArchive;
use Illuminate\Support\Facades\Storage;

class FolderService
{
    public function createFolder(Request $request)
    {
        $dirPath = storage_path('app/uploads/archives');

        if (!is_dir($dirPath)) {
            if (!mkdir($dirPath, 0777, true)) {
                return 'Error: Failed to create directory.';
            }
        }

        $file = $request->file('file');
        $dirName = str_replace(" ", '', $file->getClientOriginalName());
        $archivePath = $file->storeAs('uploads/archives', $dirName);

        $folder = Folder::create([
            'name' => $file->getClientOriginalName(),
            'user_id' => auth()->id(),
            'folder_name' => $dirName,
            'path' => $archivePath,
        ]);

        $zip = new ZipArchive;

        $path = storage_path('app/' . $archivePath);
        if ($zip->open($path) === TRUE) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);
                if (substr($filename, -1) !== '/' && pathinfo($filename, PATHINFO_EXTENSION) == "pdf") {
                    // save file in storage_path('app/uploads/archives/files/$filename');
                    $contents = $zip->getFromIndex($i);
                    $file_path = $dirPath . "/files/" . pathinfo($dirName, PATHINFO_FILENAME);

                    if (!is_dir($file_path)) {
                        if (!mkdir($file_path, 0777, true)) {
                            return 'Error: Failed to create directory.';
                        }
                    }

                    file_put_contents($file_path . "/file_$i.pdf", $contents);

                    File::create([
                        'name' => "file_$i.pdf",
                        'path' => $file_path . "/file_$i.pdf",
                        'folder_id' => $folder->id
                    ]);
                }
            }
            $zip->close();
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
