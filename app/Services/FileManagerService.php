<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileManagerService
{
    protected $disk = "uploads";
    public function storeFile($model, array|UploadedFile $files, $folderPath, $relationName = 'media', ?callable $typeResolver = null)
    {
        $files = is_array($files) ? $files : [$files];
        $storedRecords = [];

        foreach ($files as $file) {
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $path = $file->storeAs($folderPath, $fileName, $this->disk);

            $storedRecords[] = $model->{$relationName}()->create([
                'uuid' => Str::uuid(),
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'type' => $typeResolver ? $typeResolver($file) : $this->detectFileType($file)
            ]);
        }

        return $storedRecords;
    }

    public function deleteFile($model, $fileId, $relationName = 'media')
    {
        $fileRecord = $model->{$relationName}()->find($fileId);
        if (!$fileRecord) {
            throw new NotFoundException("File");
        }

        if (Storage::disk($this->disk)->exists($fileRecord->path)) {
            Storage::disk($this->disk)->delete($fileRecord->path);
        }

        return $fileRecord->delete();
    }

    public function detectFileType($file)
    {
        $mime = $file->getMimeType();
        if (str_contains($mime, 'image')) return 'image';
        if (str_contains($mime, 'video')) return 'image';
        return 'file';
    }
}
