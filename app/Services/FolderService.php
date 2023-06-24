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
        $file = $request->file('file');
        if (!$file) {
            return 'Error: File not found.';
        }

        $dirPath = storage_path('app/uploads/archives');

        $this->checkedDir($dirPath);

        // получение пути и сохранения его по имени файл_таймстамп
        $dirName = str_replace(" ", '', $file->getClientOriginalName());
        $timestamp = time();
        $dirName = pathinfo($dirName, PATHINFO_FILENAME) . '_' . $timestamp . '.' . pathinfo($dirName, PATHINFO_EXTENSION);

        $archivePath = $file->storeAs('uploads/archives', $dirName);

        $folder = Folder::create([
            'name' => $file->getClientOriginalName(),
            'user_id' => auth()->id(),
            'folder_name' => $dirName,
            'path' => $archivePath,
        ]);

        $this->zipWork($archivePath, $dirName, $dirPath, $folder);

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

    protected function checkedDir($file_path)
    {
        if (!is_dir($file_path)) {
            if (!mkdir($file_path, 0777, true)) {
                return 'Error: Failed to create directory.';
            }
        }
    }

    protected function zipWork($archivePath, $dirName, $dirPath, $folder)
    {
        $zip = new ZipArchive;

        $path = storage_path('app/' . $archivePath);
        if ($zip->open($path) === TRUE) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $filename = $zip->getNameIndex($i);
                if (substr($filename, -1) !== '/' && pathinfo($filename, PATHINFO_EXTENSION) == "pdf") {
                    // save file in storage_path('app/uploads/archives/files/$filename');
                    $contents = $zip->getFromIndex($i);
                    $file_path = $dirPath . "/files/" .  dirname($filename) ;

                    $this->checkedDir($file_path);

                    file_put_contents($file_path . "/file_$i.pdf", $contents);
                    File::create([
                        'name' => "file_$i.pdf",
                        'path' => dirname($filename) . "/file_$i.pdf",
                        'folder_id' => $folder->id
                    ]);
                }
            }
            $zip->close();
        } else {
            return 'Архив не смог открыться';
        }
    }
}
