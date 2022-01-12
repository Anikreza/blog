<?php


namespace App\Services;


use App\Enums\FileDirectory;
use File;
use Image;

class FileUpload
{
    protected object $file;
    protected string $directory;
    protected bool $isImage = false;
    protected int $width = 0;
    protected int $height = 0;
    protected string $filePath;
    protected string $fileName;
    protected string $extension;

    public function __construct($file)
    {
        $this->file = $file;
        $this->extension = $this->file->getClientOriginalExtension();
    }

    protected function createDirectory(): bool
    {
        if (!File::exists(public_path($this->directory))) {
            File::makeDirectory(public_path($this->directory), 0777, true, true);
        }

        return true;
    }

    protected function setFilePath()
    {
        $this->filePath = $this->directory . '/' . $this->fileName;
    }

    protected function uploadImage(): bool
    {
        $mainFile = $this->file;

        if ($this->extension == 'svg') {
            file_put_contents(public_path($this->filePath), $mainFile);
        } elseif ($this->height > 0) {
            $width = $this->width == 0 ? null : $this->width;
            $height = $this->height == 0 ? null : $this->height;

            Image::make($mainFile)->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path($this->filePath));
        } elseif ($this->width == null && $this->height == null) {
            Image::make($mainFile)->save(public_path($this->filePath));
        }

        return true;
    }

    protected function uploadFile(): bool
    {
        // @todo write function of upload file
        return true;
    }

    public function directory($directory = false): FileUpload
    {
        if ($directory) {
            $this->directory = $directory;
        } else {
            $this->directory = FileDirectory::ROOT;
        }
        $this->createDirectory();

        return $this;
    }

    public function setDimension($width = null, $height = null): FileUpload
    {
        $this->isImage = true;
        $this->width = $width ?? 0;
        $this->height = $height ?? 0;

        return $this;
    }

    public function setFileName($fileName = null): FileUpload
    {
        if ($fileName) {
            $this->fileName = $fileName;
        } else {
            $this->fileName = time() . '.' . $this->extension;
        }

        return $this;
    }


    public function upload(): array
    {
        $this->setFilePath();

        if ($this->isImage) {
            $this->uploadImage();
        } else {
            $this->uploadFile();
        }

        return [
            'main_file_name' => File::exists(public_path($this->filePath)) ? $this->filePath : null,
        ];
    }
}
