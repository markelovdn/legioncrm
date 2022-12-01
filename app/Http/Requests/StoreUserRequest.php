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
            'id' => ['integer'],
            'secondname' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'patronymic' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required'],
            'email' => ['required_without:id', 'unique:users', 'max:255'],
            'phone' => ['required_without:id', 'unique:users'],
            'role_code' => ['required_without:id', 'string'],
            'reg_code' => ['required_without:id', 'int'],
            'password' => ['required_without:id', 'string', 'min:6', 'confirmed'],
        ];
    }
}
