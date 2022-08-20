<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
            'parent_id' => 'nullable',
            'parent_name' =>'required||max:120',
            'parent_email' => 'required|email|unique:users,email',
            'parent_phone' => 'required|min:11|numeric',
            'preferred_institute_id' => 'nullable',
        ];
    }
}
