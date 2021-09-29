<?php

 // use Intervention\Image\Exception\NotReadableException;
 use Illuminate\Support\Facades\File;
 use Carbon\Carbon;
 use Illuminate\Support\Facades\Mail;
 use Illuminate\Support\Facades\DB;


function deleteFile($path,$name){
    if($name!=null):
        File::delete(public_path($path.$name));
        File::delete(public_path($path.'/thumb_'.$name));
    endif;
    return TRUE;
}
function storeFile($file,$path,$name){

    try{
        if (!file_exists($path))
        mkdir($path, 0777, TRUE);
        $imageSizeArray = getimagesize($file);
        $imageTypeArray = $imageSizeArray[2];
       
        $ret=TRUE;
       
           
        $file->move($path,$name);
       
    
        return $ret;
        
    }catch(\Exception $e){
        return response()->json( ["exception" => $e->getMessage()],417);
    }
   
}

