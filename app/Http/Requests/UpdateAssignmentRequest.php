<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\UniqueAttemptDateRule;

class DailyAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user('api')->can('update', $this->route('daily_assignment'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'attempt_date'=>[
                'required',
                'date_format:Y-m-d',
                new UniqueAttemptDateRule($this->route('daily_assignment')->classroom_id, $this->route('daily_assignment')->id)
            ],
            'unit_id'=>'required|exists:units,id',
            'start_time'=>'nullable|date_format:H:i:s',
            'end_time'=>'nullable|date_format:H:i:s',
        ];
    }

    public function messages()
    {
        return [
            'attempt_date.UniqueAttemptDateRule'=>'Assignment with same date already exists.'
        ]
    }
}
