<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompetitorRequest extends FormRequest
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
            'gender' => ['required_with:coach_id'],
            'secondname' => ['required_with:coach_id', 'string', 'max:40'],
            'firstname' => ['required_with:coach_id', 'string', 'max:20'],
            'patronymic' => ['required_with:coach_id', 'string', 'max:40'],
            'date_of_birth' => ['required_with:coach_id'],
            'weight' => ['required', 'numeric', 'max:150', 'min:15'],
            'coach_code' => ['required_with:coach_id', 'numeric'],
            'sportkval_id' => ['required_with:coach_id', 'numeric'],
            'tehkval_id' => ['required_with:coach_id', 'numeric'],
            'coach_id' => ['required_with:secondname', 'numeric'],
        ];
    }
}
