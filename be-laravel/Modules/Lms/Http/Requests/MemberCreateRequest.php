<?php

namespace Modules\Lms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type_show' => 'required|in:AUTO_FILL,MANUAL_FILL',
            'firstname' => 'nullable|string|min:2|max:255|required_if:type_show,MANUAL_FILL',
            'lastname' => 'nullable|string|min:2|max:255|required_if:type_show,MANUAL_FILL',
            'birth_day' =>  'nullable',
            'mobile' => 'nullable|numeric|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:lms_members,mobile|required_if:type_show,MANUAL_FILL',
            'email' => 'required|email|unique:lms_members,email',
            'type' => 'required|in:STUDENT,TEACHER,ADMIN',
            'avatar_url' => 'nullable',
            'classroom_ids' => 'nullable|array',
            'classroom_ids.*' => 'integer|exists:lms_classrooms,id',
            'role_id' => 'integer|exists:lms_roles,id'
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
