<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentCreateRequest extends FormRequest
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
            'course_id'=>'required|numeric',
            'course_name'=>'required',
            'institute_id'=>'nullable|numeric',
            'institute_name'=>'required',
            'college_id'=>'nullable|alpha_num',
        ];
    }
}
