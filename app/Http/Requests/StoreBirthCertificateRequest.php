<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBirthCertificateRequest extends FormRequest
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
            'birthcertificate_series' => ['required'],
            'birthcertificate_number' => ['required', 'numeric'],
            'birthcertificate_date_issue' => ['required'],
            'birthcertificate_issued_by' => ['required', 'string'],
            'birthcertificate_scan' => ['required', 'image:jpg,jpeg,png,bmp'],
        ];
    }
}
