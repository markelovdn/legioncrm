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
            'birthcertificate_scan' => ['required_without:user_id', 'image:jpg,jpeg,png'],
            'birthcertificate_series' => ['required'],
            'user_id' => ['numeric'],
            'birthcertificate_number' => ['required', 'numeric'],
            'birthcertificate_date_issue' => ['required'],
            'birthcertificate_issued_by' => ['required', 'string'],
        ];
    }
}
