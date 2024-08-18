<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

//use Sabberworm\CSS\Rule\Rule;

class StoreOrganizationRequest extends FormRequest
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
            'fulltitle' => ['required', 'string', Rule::unique('organizations', 'fulltitle')->ignore($this->organization)],
            'shorttitle' => ['required', 'string', Rule::unique('organizations', 'shorttitle')->ignore($this->organization)],
            'address' => ['string', Rule::unique('organizations', 'address')->ignore($this->organization)],
            'email' => ['string', Rule::unique('organizations', 'email')->ignore($this->organization)],
            'phone' => ['string', Rule::unique('organizations', 'phone')->ignore($this->organization)],
            'inn' => ['numeric', Rule::unique('organizations', 'inn')->ignore($this->organization)],
            'ogrn' => ['numeric', Rule::unique('organizations', 'ogrn')->ignore($this->organization)],
            'primary_activity' => ['string'],
            'logo' => ['image:jpg,jpeg,png'],
            'code' => ['numeric', Rule::unique('organizations', 'code')->ignore($this->organization)],
        ];
    }
}
