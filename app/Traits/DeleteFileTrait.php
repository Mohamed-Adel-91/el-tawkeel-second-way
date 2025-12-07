<?php

namespace App\Traits;

trait DeleteFileTrait
{

    public function deleteFile(?string $filename, string $folder): void
    {
        if ($filename) {
            $pathStartsWithRoot = preg_match('#^(?:[a-zA-Z]:[\\\\/]|[\\\\/]{2}|/)#', $folder) === 1;
            $directory = $pathStartsWithRoot
                ? rtrim($folder, '/\\')
                : base_path(trim($folder, '/\\'));
            $filePath = $directory . DIRECTORY_SEPARATOR . ltrim($filename, '/\\');
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }

}
