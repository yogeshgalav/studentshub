<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PhoneRule;

class VerifyContactRequest extends FormRequest
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
            "phone_number"=>"required|numeric|digits:10",
            "country_code"=>"required|max:3",
        ];
    }

    public function messages()
    {
        return [
            "phone_number.*"=>"You must provide a valid phone number.",
        ];
    }
}
