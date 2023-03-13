<?php

namespace App\BusinessProcess;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadFile
{
    public function uploadFile($id, $user_secondname, $user_firstname, $prefix, $file)
    {
        if ($file->extension() == 'pdf' || $file->extension() == 'PDF'
            || $file->extension() == 'jpg' || $file->extension() == 'jpeg'
            || $file->extension() == 'png') {

            $main_url = config('filesystems.disks.s3.endpoint').'/'.config('filesystems.disks.s3.bucket').'/';

            $filename = $id.'_'.$user_secondname.'_'.$user_firstname.
                '/'.$prefix.'_'.$id.'_'.$user_secondname.'_'.$user_firstname.'.jpg';

            if ($file->extension() == 'pdf' || $file->extension() == 'PDF') {
                $filename = $id.'_'.$user_secondname.'_'.$user_firstname.
                    '/'.$prefix.'_'.$id.'_'.$user_secondname.'_'.$user_firstname.'.pdf';
                if ($prefix) {
                    Storage::disk('s3')->put($filename, $file->openFile()->fread($file->getSize()));
                }
                return $main_url.$filename;
            }

            switch ($prefix) {
                case ('photo'):
                    $resize = 354;
                    break;
                default:
                    $resize = 520;
            };

            $img = Image::make($file)->resize($resize, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $filecontent = $img->stream();

            if ($prefix) {
                Storage::disk('s3')->put($filename, $filecontent->__toString());
            }

            return $main_url.$filename;
        } else {
            return false;
        }

    }
}

//$main_url = config('filesystems.disks.s3.endpoint').'/'.config('filesystems.disks.s3.bucket').'/';
//
//$filecontent = $file->openFile()->fread($file->getSize());
//$filename = $id.'_'.$user_secondname.'_'.$user_firstname.
//    '/'.$prefix.'_'.$id.'_'.$user_secondname.'_'.$user_firstname.'.jpg';
//
//if ($prefix) {
//    Storage::disk('s3')->put($filename, $filecontent);
//}
//
//return $main_url.$filename;
