<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInstituteContactRequest extends FormRequest
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
            'edit_institute_contact_id' => 'nullable',
            'edit_institute_contact_id' => 'nullable',
            'email' => 'required|email|unique:users,email',
            'phone_no' => 'required|min:11',
            'phone_no2' => 'nullable|min:11',
            'whatsapp_no' => 'required', 
            'department' => 'required',
        ];
    }
}
