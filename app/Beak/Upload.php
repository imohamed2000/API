<?php

namespace App\Beak;

use App\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File as FI;
class Upload{

    private $requestName;
    private $storageDriver;
    private $operation;
    private $fileId;
    private $filename;
    private $originalFilename;
    private $type;
    private $extension;
    private $size;
    public $savedFile;

    public function __construct($requestName,$storageDriver,$operation,$id = Null)
    {
        $this->requestName = $requestName;
        $this->operation = $operation;
        $this->storageDriver = $storageDriver;
        if($this->operation == 'add')
        {
            return $this->addFile();
        }
        else
        {
            $this->fileId = $id;
            return $this->editFile();
        }
    }

    private function addFile()
    {
        $this->uploadFile();
        $saveFile = new File();
        $saveFile->filename = $this->filename;
        $saveFile->original_name = $this->originalFilename;
        $saveFile->type = $this->type;
        $saveFile->size = $this->size;
        $saveFile->extension = $this->extension;
        $saveFile->save();
        $this->savedFile = $saveFile;
        return $this->savedFile;
    }

    private function editFile()
    {
        $this->uploadFile();
        $saveFile = File::findOrFail($this->fileId); // Find old File
        Storage::disk($this->storageDriver)->delete($saveFile->filename); // Delete Old File from server
        $saveFile->filename = $this->filename;
        $saveFile->original_name = $this->originalFilename;
        $saveFile->type = $this->type;
        $saveFile->size = $this->size;
        $saveFile->extension = $this->extension;
        $saveFile->save(); // Save New file to database
        $this->savedFile = $saveFile;
        return $this->savedFile;
    }

    private function uploadFile()
    {
        $this->extension = request()->file($this->requestName)->getClientOriginalExtension(); // getting image extension
        $file = request()->file($this->requestName);
        $this->filename = $this->requestName.time().rand(0000000,9999999999).'-'.rand(0000000000000,99999999999).time().'.'.$this->extension; // renaming image
        $this->type = request()->file($this->requestName)->getMimeType();
        $this->size = request()->file($this->requestName)->getClientSize();
        $this->originalFilename = request()->file($this->requestName)->getClientOriginalName();
        Storage::disk($this->storageDriver)->put($this->filename,  FI::get($file));
    }

}