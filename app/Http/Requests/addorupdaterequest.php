<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addorupdaterequest extends FormRequest
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
            'email'  => 'required',
            'phone_no'  => 'required',
            'phone_no2'  => 'nullable',
            'whatsapp_no'  => 'required',
            'department'  => 'required',
            'institute_id' => 'required',

        ];
    }
}
