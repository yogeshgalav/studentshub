<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'full_name'=>'required|string|min:1|max:255',
            'email'=>'required|email|max:255',
            'password'=>'required|min:6|max:16',
            // 'confirm_password'=>'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'email.email'=>'You must provide a valid email address.',
            'email.unique'=>'You are already registered, Please Login.'
        ];
    }
}
