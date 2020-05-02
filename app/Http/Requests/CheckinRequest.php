<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckinRequest extends FormRequest
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
            // 'course.id'=>'required|numeric',
            // 'course.course_name'=>'required',
            // 'course.category_id'=>'required|numeric',
            // 'institute.id'=>'required|numeric',
            // 'institute.name'=>'required',
            'college_id'=>'nullable|alpha_num',
            'start_year'=>'required|date_format:Y',
            'end_year'=>'required|date_format:Y',
        ];
    }
}
