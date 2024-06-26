<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Enum;
use Modules\Auth\Enums\UserInfoType;

class AdminUserUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // 'type' => ['required',new Enum(ExamChanelType::class)]

        return [
            'username' => ['required', 'string', 'min:6', 'max:50'],
            'email' => ['required', 'string', 'email'],
            'mobile' => ['required', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
            // 'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            // 'password_confirmation' => ['required', 'string'],
            // 'user_info' => ['required'],
            // 'user_info.first_name' => ['required', 'string', 'max:50'],
            // 'user_info.last_name' => ['required', 'string', 'max:50'],
            // 'user_info.birthday' => ['date'],
            // 'user_info.gender' => ['string', 'in:MALE,FEMALE'],
            // 'user_info.avatar_url' => ['string'],
            // 'user_info.type' => ['required', new Enum(UserInfoType::class)],
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
