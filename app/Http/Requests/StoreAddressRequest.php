<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'country_id' => ['required', 'numeric'],
            'district_id' => ['required', 'numeric'],
            'region_id' => ['required', 'numeric'],
            'address' => ['required', 'string'],
            'user_id' => ['numeric'],
            'registration_scan' => ['required_without:user_id', 'image:jpg,jpeg,png,bmp'],
        ];
    }
}
