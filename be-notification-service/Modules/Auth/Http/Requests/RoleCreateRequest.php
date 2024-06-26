<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class RoleCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'unique:auth_roles,name'],
            'label' => ['required'],
            'guard_name' => ['required', Rule::in(['api'])]
        ];
    }

    public function bodyParameters()
    {
        return [
            'name' => [
                'description' => 'Tên vai trò',
                'example' => 'admin',
            ],
            'label' => [
                'description' => 'Tên hiển thị',
                'example' => 'Quản trị viên',
            ],
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
