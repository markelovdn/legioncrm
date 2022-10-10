<?php


namespace App\Actions;


use App\Http\Requests\StoreUserRequest;
use App\Models\Coach;
use App\Models\Organization;

class GetRegistrationCode
{
    public function getCode(StoreUserRequest $request)
    {
        $reg_code = "";
        switch ($request->role_id) {
            case ("5"): $reg_code = Coach::find($request->input('coach_id'));
                $request->only(['coach_id']);
                break;
            case ("4"): $reg_code = Organization::find($request->input('org_id'));
                $request->only(['org_id']);
                break;
        };
        if ($reg_code->code == $request->reg_code) {
            return $reg_code;
            }
        else {
            $request->session()->flash('status', 'Не верный код');
            return back()->withInput();
        }
    }
}
