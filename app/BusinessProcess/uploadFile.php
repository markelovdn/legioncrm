<?php

namespace App\BusinessProcess;

use Illuminate\Support\Facades\Storage;

class uploadFile
{
    public function uploadFile($id, $user_secondname, $user_firstname, $prefix, $file)
    {
        $main_url = env('AWS_ENDPOINT').'/'.env('AWS_BUCKET').'/';

        $filecontent = $file->openFile()->fread($file->getSize());
        $filename = $id.'_'.$user_secondname.'_'.$user_firstname.
            '/'.$prefix.'_'.$id.'_'.$user_secondname.'_'.$user_firstname.'.jpg';

        if ($prefix) {
            Storage::disk('s3')->put($filename, $filecontent);
        }

        return $main_url.$filename;
    }
}
