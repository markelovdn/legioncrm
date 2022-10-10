<?php


namespace App\Service;


use App\Actions\GetRegistrationCode;
use App\Http\Requests\StoreUserRequest;
use App\Models\Coach;
use App\Models\Parented;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrationUserAs
{
    public function registrationUser(StoreUserRequest $request)
    {
            $user = new User();

            $user->firstname = $request->firstname;
            $user->secondname = $request->secondname;
            $user->patronymic = $request->patronymic;
            $user->date_of_birth = $request->date_of_birth;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->role_id = $request->role_id;
            $user->password = Hash::make($request->password);

            $user->save();

        Auth::login($user);

        switch ($request->role_id) {
            case ("5"):
                $parented = new Parented();
                $parented->user_id = auth()->user()->id;
                $parented->save();
                return '/parented/' . $parented->id;
            case ("4"):
                $coach = new Coach();
                $coach->user_id = auth()->user()->id;
                $coach->code = rand(1000, 9999);
                $coach->save();
                return '/coach/' . $coach->id;
        }

    }
}


