<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClassroomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api')->can('createClassroom', Institute::find($this->input('institute_id')));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject_name'=>'required|string|max:125',
            'course_id'=>'required|numeric|exists:courses,id',
            'classroom_name'=>'required|string|max:125',
        ];
    }
}
