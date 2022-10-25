<?php


namespace App\BusinessProcess;

use App\Models\Coach;
use App\Models\Organization;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class GetRegistrationCode
{
    public function getCode(int $code, string $role_code)
    {
        $reg_code = "";
        switch ($role_code) {
            case (Role::ROLE_PARENTED):
                $reg_code = Coach::where('code', $code)->first();
                break;
            case (Role::ROLE_COACH):
                $reg_code = Organization::where('code', $code)->first();
                break;
            case (Role::ROLE_ORGANIZATION_CHAIRMAN):
                $reg_code = DB::table('system_codes')->where('code', $code)->first();
                break;
        };

        if (isset($reg_code->code) && $reg_code->code == $code) {
            return $reg_code;
            }
    }
}
