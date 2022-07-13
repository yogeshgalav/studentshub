<?php

namespace App\Http\Requests;

use App\Models\Chatroom;
use App\Models\Institute;
use Illuminate\Foundation\Http\FormRequest;
use Session;

class LoginRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $chatId = Session::get('chatId');
        $inId = Session::get('inId');
        if ($chatId && $chat = Chatroom::where('uuid', $chatId)->find()) {
            $this->merge(['chatId' => $chat->id]);
        }
        if ($inId && Institute::where('id', $inId)->exists()) {
            $this->merge(['inId' => $inId]);
        }
        if (isset($_COOKIE['fcmToken'])) {
            $this->merge(['fcmToken' => base64_decode($_COOKIE['fcmToken'])]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fcmToken' => 'nullable|string',
            'phone_number' => 'required',
            'otp' => 'required|digits:5',
            // 'confirm_password'=>'required|min:6',
        ];
    }

    public function messages()
    {
        return [];
    }
}
