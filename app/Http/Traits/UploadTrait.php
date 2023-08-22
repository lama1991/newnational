<?php
namespace App\Http\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadTrait
{
    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
       
        if (is_null($filename))
        {
            $name=Str::random(16).$uploadedFile->getClientOriginalName();
        }
        else
        {
            $name=$filename;
        }


        $image_path = $uploadedFile->storeAs($folder, $name, $disk);

        return  $image_path;
    }
    
    public function uploadMulti(array $uploadedFiles, $folder = null, $disk = 'local')
    {
       
        foreach($uploadedFiles as $file) {
            $name=Str::random(16).$file->getClientOriginalName();
            $destenation=$folder.'/'.$name;
          Storage::disk($disk)->put( $destenation, file_get_contents($file));
       // $pathes[]=Storage::disk($disk)->getDriver()->getAdapter()->applyPathPrefix($name);
        // $pathes[]=Storage::url('app/'.$destenation);
        $pathes[]=storage_path('app/'.$destenation);

     }
       
     return   $pathes;
    }
}