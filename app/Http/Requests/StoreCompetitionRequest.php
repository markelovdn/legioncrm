<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompetitionRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:250'],
            'org_id' => ['required', 'integer'],
            'status' => ['required', 'integer'],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'district_id' => ['required', 'integer', 'exists:districts,id'],
            'region_id' => ['required', 'integer', 'exists:regions,id'],
            'address' => ['required', 'string'],
            'date_start' => ['required', 'date'],
            'date_end' => ['required', 'date'],
            'linkreport' => ['required', 'string'],
            'agecategory' => ['required', 'array', 'exists:age_categories,id']
        ];
    }
}
