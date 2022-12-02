<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Coach;
use App\Models\Parented;
use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function redirectTo()
    {
        if (User::isParented(auth()->user())) {
            $parented = Parented::with('user')->where('user_id', auth()->user()->id)->get();
            $parented_id = '';
            foreach ($parented as $item) {
                $parented_id = $item->id;
            }
            return url('/parented',$parented_id);
        }

        if (User::isCoach(auth()->user())) {
            $coach = Coach::with('user')->where('user_id', auth()->user()->id)->get();
            $coach_id = '';
            foreach ($coach as $item) {
                $coach_id = $item->id;
            }
            return url('/coach',$coach_id);
        }

        return url('/');

//        switch (auth()->user()->role_code) {
//            case (Role::ROLE_PARENTED):
//                $parented = Parented::with('user')->where('user_id', auth()->user()->id)->get();
//                $parented_id = '';
//                foreach ($parented as $item) {
//                    $parented_id = $item->id;
//                }
//                return url('/parented',$parented_id);
//            case (Role::ROLE_ATHLETE):
//                $coach = Coach::with('user')->where('user_id', auth()->user()->id)->get();
//                $coach_id = '';
//                foreach ($coach as $item) {
//                    $coach_id = $item->id;
//                }
//                return url('/coach',$coach_id);
//        }
    }
}
