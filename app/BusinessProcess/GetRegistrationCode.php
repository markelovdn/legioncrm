<?php


namespace App\BusinessProcess;

use App\Models\Coach;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;

class GetRegistrationCode
{
    public function getCode($code, $role_code)
    {
        $reg_code = "";
        switch ($role_code) {
            case ("parented"):
                $reg_code = Coach::where('code', $code)->first();
                break;
            case ("coach"):
                $reg_code = Organization::where('code', $code)->first();
                break;
            case ("organization_chairman"):
                $reg_code = DB::table('system_codes')->where('code', $code)->first();
                break;
        };

        if (isset($reg_code->code) && $reg_code->code == $code) {
            return $reg_code;
            }
    }
}
