<?php

namespace App\DomainService;

use App\Models\Coach;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;

class AttachOrganization
{
    public function attachOrganization($role_code, $id, $reg_code = null)
    {
        switch ($role_code) {
            case (Role::ROLE_PARENTED):
            case (Role::ROLE_ATHLETE):
                $coach = Coach::with('user')->where('code', $reg_code)->first();
                $org = $coach->user->organizations->first()->id;

                $user = User::find($id);
                $user->organizations()->syncWithoutDetaching($org);

            case (Role::ROLE_COACH):
            case (Role::ROLE_REFEREE):
            $org = Organization::where('code', $reg_code)->first();

            $user = User::find($id);
            $user->organizations()->attach($org);

            default:
                session()->flash('error', 'Неизвестная роль'.$role_code);

                return redirect('/');
        }
    }
}
