<?php


namespace App\BusinessProcess;


use App\Models\Athlete;
use App\Models\Role;

class GetCompetitiors
{
    public function getCompetitors (string $role_code)
    {
        switch ($role_code)
        {
            case (Role::ROLE_COACH):
                return Athlete::with('coaches', 'user', 'tehkval', 'sportkval')->has('coaches')->get();;
        }
    }


}
