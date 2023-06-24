<?php

namespace App\Services;

use App\Models\File;
use App\Models\Folder;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use ZipArchive;

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

        return $this->ZipTo($folder->id);
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
                    $file_path2 = $dirPath . "/files/" . "$dirName/" . dirname($filename);

                    $this->checkedDir($file_path2);

                    file_put_contents($file_path2 . "/file_$i.pdf", $contents);
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

    public function ZipTo($id)
    {
        $model = Folder::where('id', $id)->first();

        $dirTo = "../storage/app/uploads/other-files/" . $model->folder_name;
        $dirFrom = "../storage/app/uploads/archives/files/" . $model->folder_name;

        $res = Process::run("ls ../storage/app/uploads/archives/files/" . $model->folder_name);
        $res2 = Process::run("ls $dirFrom/Test\ Small");
        
        $ex = exec("zip -r -j $dirTo $dirFrom");

        $url_i = 'http://178.205.138.31:6432/check_project';

        // Prepare the request data
        $data = [
            'id' => $model->id,
            'extra_name' => 'Общество с ограниченной ответственностью "КАББАЛКГИПРОТРАНС"',
        ];

        // Set the file path of the archive to be uploaded

        // Create a Guzzle client instance
        $client = new Client();

        $start_time = microtime(true);
        $response = $client->request('POST', $url_i, [
            'query' => $data,
            'multipart' => [
                [
                    'name' => 'request_archive',
                    'contents' => fopen($dirTo, 'rb')
                ]
            ]
        ]);
        $end_time = microtime(true);
        $request_time = $end_time - $start_time;
        echo "Время выполнения запроса: " . $request_time . " секунд" . PHP_EOL;

        // return $response->getBody()->getContents();
        $dev = $response->getBody()->getContents();

        return $dev;
    }
}
