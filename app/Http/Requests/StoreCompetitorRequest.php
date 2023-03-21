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
            'weight' => ['required', 'numeric', 'max:150', 'min:15'],
            'sportkval_id' => ['required', 'numeric'],
            'tehkval_id' => ['required', 'numeric'],
            'competition_id' => ['required', 'numeric'],
        ];
    }
}
