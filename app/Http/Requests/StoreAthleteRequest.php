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
            'photo' => ['required', 'image:jpg,jpeg,png,bmp', 'max:3000'],
            'gender' => ['required', 'integer', 'max:2'],
            'secondname' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'patronymic' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date'],
            'coach_id' => ['required'],
            'reg_code' => ['required'],
        ];
    }
}
