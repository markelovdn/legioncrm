<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePassportRequest extends FormRequest
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
            'passport_series' => ['required', 'numeric', 'max:9999'],
            'passport_number' => ['required', 'numeric'],
            'passport_date_issue' => ['required'],
            'passport_issued_by' => ['required', 'string'],
            'passport_subcode' => ['required'],
            'role_code' => ['string'],
            'passport_scan' => ['required_with:role_code', 'image:jpg,jpeg,png']
        ];
    }
}
