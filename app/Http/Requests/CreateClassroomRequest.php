<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Institute;
use App\Models\Classroom;

class CreateClassroomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api')->canCreateClassroom();
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
