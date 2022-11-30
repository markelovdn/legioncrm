<?php


namespace App\DomainService;


use App\BusinessProcess\GetRegistrationCode;
use App\Http\Requests\StoreUserRequest;
use App\Models\Athlete;
use App\Models\Coach;
use App\Models\Organization;
use App\Models\Parented;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrationUserAs
{

    public function registrationUserAs($role_code, $id)
    {
        switch ($role_code) {
            case (Role::ROLE_PARENTED):
                $parented = new Parented();
                $parented->user_id = $id;
                $parented->save();
                return $user_type = '/parented/'.$parented->id;
            case (Role::ROLE_COACH):
                $coach = new Coach();
                $coach->user_id = $id;
                $coach->code = rand(1000, 9999);
                $coach->save();
                return $user_type = '/coach/'.$coach->id;
            case (Role::ROLE_ATHLETE):
                $athlete = new Athlete();
                $athlete->user_id = $id;
                $athlete->save();
                return $user_type = '/athlete/'.$athlete->id;
            case (Role::ROLE_ORGANIZATION_CHAIRMAN):
                $org = new Organization();
                $org->code = rand(1000, 9999);
                $org->save();

                $user = User::find($id);
                $user->organizations()->attach($org);

                return $user_type = '/organization/'.$org->id;

            default:
                throw new Exception('Неизвестная роль');
        }

    }
}


