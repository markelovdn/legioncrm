<?php

namespace App\Http\Controllers;

use App\BusinessProcess\uploadFile;
use App\Models\Address;
use App\Models\Athlete;
use App\Models\BirthCertificate;
use App\Models\Passport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function post_reg(Request $request)
    {
        $user_id = rand(1,100);
        $user_secondname = 'test_secondname';
        $user_firstname = 'test_firstname';

        $file = $request->file('registration_scan');
        $filecontent = $file->openFile()->fread($file->getSize());
        $filename = 'athlete/'.$user_id.'_'.$user_secondname.'_'.$user_firstname.
            '/registration_scan_'.$user_id.'_'.$user_secondname.'_'.$user_firstname.'.jpg';

        if ($request->hasFile('registration_scan')) {
            Storage::disk('s3')->put($filename, $filecontent);
        }

        return back();
    }

    public function post_foto(Request $request)
    {
        if ($request->hasFile('foto')) {
            uploadFile::uploadFile(3, 'test','test', 'foto', $request->file('foto'));
        }

//        $user_id = 3;
//        $user_secondname = 'test_secondname1';
//        $user_firstname = 'test_firstname2';
//
//        $file = $request->file('foto');
//        $filecontent = $file->openFile()->fread($file->getSize());
//        $filename = 'athlete/'.$user_id.'_'.$user_secondname.'_'.$user_firstname.
//            '/foto2_1'.$user_id.'_'.$user_secondname.'_'.$user_firstname.'.jpg';
//
//        if ($request->hasFile('foto')) {
//            Storage::disk('s3')->put($filename, $filecontent);
//        }
//
//        return back();
    }

    public function renameAddress()
    {
        $addresses = Address::all();

        foreach ($addresses as $item) {
            $address = $item->scanlink;
            $new_path = 'https://storage.yandexcloud.net/legioncrm-storage-pub/';

            $path = str_replace('athlete/','',$address);

            $item->scanlink = $new_path.$path;

            $item->save();

        }
    }

    public function renameBS()
    {
        $bss = BirthCertificate::all();

        foreach ($bss as $item) {
            $bs = $item->scanlink;
            $new_path = 'https://storage.yandexcloud.net/legioncrm-storage-pub/';

            $path = str_replace('athlete/','',$bs);

            $item->scanlink = $new_path.$path;

            $item->save();

        }
    }

    public function renamePassport()
    {
        $passports = Passport::all();

        foreach ($passports as $item) {
            if ($item->scanlink != null) {
                $passport = $item->scanlink;
                $new_path = 'https://storage.yandexcloud.net/legioncrm-storage-pub/';

                $path = str_replace('athlete/','',$passport);
                $item->scanlink = $new_path.$path;

                $item->save();
            }
        }
    }

    public function renamePhoto()
    {
        $athletes = Athlete::all();

        foreach ($athletes as $athlete) {
            $athlete_photo = $athlete->photo;
            $new_path = 'https://storage.yandexcloud.net/legioncrm-storage-pub/';

            $path = str_replace('athlete/','',$athlete_photo);
            $athlete->photo = $new_path.$path;
            $athlete->save();
        }
    }
}
