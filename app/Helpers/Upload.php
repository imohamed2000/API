<?php

namespace App\Helpers;

use App\File;
use Illuminate\Support\Facades\Storage;
class Upload{

    protected $requestName;
    protected $path;
    protected $operation;
    protected $fileId;
    protected $filename;
    protected $originalFilename;
    protected $type;
    protected $size;
    public $savedFile;



    public function __construct($requestName,$path,$operation,$id = Null)
    {
        $this->requestName = $requestName;
        $this->path = $path;
        $this->operation = $operation;
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

    public function addFile()
    {
        $this->uploadFile();
        $saveFile = new File();
        $saveFile->filename = $this->filename;
        $saveFile->original_name = $this->originalFilename;
        $saveFile->type = $this->type;
        $saveFile->size = $this->size;
        $saveFile->save();
        $this->savedFile = $saveFile;
        return $this->savedFile;
    }

    public function editFile()
    {
        $this->uploadFile();
        $saveFile = File::findOrFail($this->fileId); // Find old File
        Storage::delete($this->path.'/'.$saveFile->filename); // Delete Old File from server
        $saveFile->filename = $this->filename;
        $saveFile->original_name = $this->originalFilename;
        $saveFile->type = $this->type;
        $saveFile->size = $this->size;
        $saveFile->save(); // Save New file to database
        $this->savedFile = $saveFile;
        return $this->savedFile;
    }

    protected function uploadFile()
    {
        $extension = request()->file($this->requestName)->getClientOriginalExtension(); // getting image extension
        $this->filename = $this->requestName.time().rand(0000000,9999999999).'-'.rand(0000000000000,99999999999).time().'.'.$extension; // renaming image
        $this->type = request()->file($this->requestName)->getMimeType();
        $this->size = request()->file($this->requestName)->getClientSize();
        $this->originalFilename = request()->file($this->requestName)->getClientOriginalName();
        request()->file($this->requestName)->move($this->path, $this->filename); // uploading file
    }

}