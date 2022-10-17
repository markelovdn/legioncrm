<?php


namespace App\DomainService;


use App\BusinessProcess\GetRegistrationCode;
use App\Http\Requests\StoreUserRequest;
use App\Models\Coach;
use App\Models\Parented;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrationUserAs
{
    public function registrationUserAs($role_id)
    {
        switch ($role_id) {
            case ("5"):
                $parented = new Parented();
                $parented->user_id = auth()->user()->id;
                $parented->save();
                return $user_type = '/parented/'.$parented->id;
            case ("4"):
                $coach = new Coach();
                $coach->user_id = auth()->user()->id;
                $coach->code = rand(1000, 9999);
                $coach->save();
                return $user_type = '/coach/'.$coach->id;
        }

    }
}


