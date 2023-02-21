<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventsRequest extends FormRequest
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
            'address' => ['required', 'string'],
            'date_start' => ['required', 'date'],
            'date_end' => ['required', 'date'],
            'info_link' => ['required', 'string'],
            'users_limit' => ['required', 'integer'],
            'early_cost' => ['required_with:early_cost_before', 'integer'],
            'early_cost_before' => ['required_with:early_cost', 'date'],
            'regular_cost' => ['required', 'integer'],
            'minimum_prepayment_percent' => ['integer'],
            'booking_without_payment_before' => ['date'],
        ];
    }
}
