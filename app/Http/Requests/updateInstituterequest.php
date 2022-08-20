<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInstituteRequest extends FormRequest
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
            'id' => 'nullable|exists',
            'name' => 'required|max:50',
            'fb_url' => 'required',
            'role' => 'required',
            'website' => 'nullable|exists',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'moto' => 'required',
            'twitter_url' => 'required',
            'insta_ur' => 'nullable',
            'twitter_url' => 'required',
        ];
    }
}
