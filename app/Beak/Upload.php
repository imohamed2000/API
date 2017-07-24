<?php

namespace App\Beak;

class upload{
    /**
     * File model variable
     * @var Model App\File
     */
    private $file;

    /**
     * Uploads file to a particular destination and disk using a random ID
     * @param  Illuminate\Http\File OR Illuminate\Http\UploadedFile $uploaded_file 
     * @param  string $destination   
     * @param  string $disk   
     * @return  string  file name               
     */
    public function put($uploaded_file, $destination = '' ,$disk = 'public'){
        // Add file to storage
        $filename = \Illuminate\Support\Facades\Storage::disk( $disk )
                                                        ->putFile( $destination, $uploaded_file );

        $this->addToDb($uploaded_file , $filename);
        return $filename;
    }

    /**
     * Uploads file to a particular destination and disk, manually specify a file name...
     * @param  Illuminate\Http\File OR Illuminate\Http\UploadedFile $uploaded_file 
     * @param  string $destination   
     * @param  string $disk 
     * @return  string  file name                       
     */
    
    public function putAs($uploaded_file , $destination = '', $name, $disk = 'public'){
        $name = $name . '.' .$uploaded_file->getClientOriginalExtension();
        $filename = \Illuminate\Support\Facades\Storage::disk( $disk )
                                                            ->putFileAs($destination, $uploaded_file, $name);

        $this->addToDb($uploaded_file , $filename);
        return $filename;
    }

    /**
     * Overrides a previously uploaded file on Disk and DB
     * @param  integer $id file id on DB [files table]
     * @param  Illuminate\Http\File OR Illuminate\Http\UploadedFile $uploaded_file 
     * @param string Disk
     * @return 
     */
    public function override($id, $uploaded_file, $disk='public'){
        $file = \App\File::findOrFail($id);
        //Replace on disk
        \Illuminate\Support\Facades\Storage::disk($disk)->delete($file->filename);

        $pathinfo = pathinfo($file->filename);
        $filename = $this->putAs(
                $uploaded_file ,
                $pathinfo['dirname'], 
                $pathinfo['filename'], 
                $disk = 'public');

        //Update on DB
        $this->addToDb($uploaded_file, $filename);
    }

    /**
     * Stores file data into DB
     * @param Illuminate\Http\File OR Illuminate\Http\UploadedFile $uploaded_file $uploaded_file [description]
     * @param string $filename  
     */
    private function addToDb($uploaded_file, $filename){

        $this->file = \App\File::firstOrcreate([
                'filename'          => $filename, 
            ]);

        $this->file->original_name    = $uploaded_file->getClientOriginalName(); 
        $this->file->type             = $uploaded_file->getClientOriginalExtension(); 
        $this->file->size             = $uploaded_file->getClientSize();
        $this->file->extension        = $uploaded_file->getClientMimeType();
        
        $this->file->save();
    }

    /**
     * @return saved file data as ORM Model Object
     */
    public function getFileData(){
        return $this->file;
    }

}
