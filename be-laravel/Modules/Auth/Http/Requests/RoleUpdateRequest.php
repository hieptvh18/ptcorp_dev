<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $role = $this->route()->role;
        return [
            'name' => ['required', 'unique:auth_roles,name,' . $role . ',id'],
            'label' => ['required'],
            'bizapp_alias' => 'required|string',
            'is_active' => 'required|boolean'
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
