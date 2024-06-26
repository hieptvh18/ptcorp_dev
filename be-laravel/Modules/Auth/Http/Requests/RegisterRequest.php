<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Enum;
use Modules\Auth\Enums\UserInfoType;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:auth_users', 'regex:/^[a-z0-9_]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:auth_users'],
            'mobile' => ['required', 'string', 'max:255', 'unique:auth_users'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required', 'string'],
            'user_type' => ['string', new Enum(UserInfoType::class)],
            'custom_data' => ['nullable', 'required_if:user_type,OTHER']
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
