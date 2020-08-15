<?php

namespace App\Http\Requests\TeacherDailyAssignment;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'unit_id' => 'required|exists:units,id',
            'attempt_date' => 'required|date|unique:daily_questions',
        ];
    }

    public function messages()
    {
        return [
            'attempt_date.required' => 'The assignment date field is required.',
            'attempt_date.date' => 'The assignment date field is not a valid date.',
            'attempt_date.unique' => 'The assignment date has already been taken.',
            'unit_id.exists' => 'The unit field is not exists.',
            'unit_id.required' => 'The unit field is required.',
        ];

    }
}
