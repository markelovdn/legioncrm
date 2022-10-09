<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'secondname' => 'required', 'string', 'max:255',
            'firstname' => 'required', 'string', 'max:255',
            'patronymic' => 'required', 'string', 'max:255',
            'date_of_birth' => 'required', 'date',
            'email' =>'required', 'string', 'email', 'max:255', 'unique:users',
            'phone' => 'required', 'unique:users',
            'role_id' => 'required', 'integer',
            'password' => 'required', 'string', 'min:6', 'confirmed',
            'coach_id' => ['required', 'integer'],
            'org_id' => ['required', 'integer'],
        ];
    }
}
