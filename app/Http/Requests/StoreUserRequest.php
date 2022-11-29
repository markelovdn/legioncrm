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
            'secondname' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'patronymic' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required'],
            'email' => ['required', 'unique:users', 'max:255'],
            'phone' => ['required', 'unique:users'],
            'role_code' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }
}
