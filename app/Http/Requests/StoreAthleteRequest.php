<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAthleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['numeric'],
            'athlete_id' => ['numeric'],
            'photo' => ['required_without:user_id', 'image:jpg,jpeg,png'],
            'gender' => ['required_without:user_id', 'integer', 'max:2'],
            'secondname' => ['required_without:user_id', 'string', 'max:255'],
            'firstname' => ['required_without:user_id', 'string', 'max:255'],
            'patronymic' => ['required_without:user_id', 'string', 'max:255'],
            'date_of_birth' => ['required_without:user_id', 'date'],
            'coach_id' => ['required_without:user_id'],
            'reg_code' => ['required_without:user_id'],
            'real_coach' => ['required_with:athlete_id', 'numeric'],
            'first_coach' => ['required_with:athlete_id', 'numeric'],
        ];
    }
}
