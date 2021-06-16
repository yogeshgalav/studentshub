<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddResourceRequest extends FormRequest
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
            'unit_id'=>'required|exists:units,id',
            'resource_type'=>'required',
           'resource_link'=>'required',
            'description'=>'required',
            'share_as_post'=>'nullable',
        ];
    }
}
