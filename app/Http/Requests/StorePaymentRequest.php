<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
            'user_id' => ['required', 'numeric'],
            'sum_payment' => ['required', 'numeric', 'max:9999999'],
            'date_payment' => ['required', 'date'],
            'paymenttitle_id' => ['required', 'numeric'],
            'scan_payment_document' => ['required', 'image:jpg,jpeg,png,bmp', 'max:1000']
        ];
    }
}
