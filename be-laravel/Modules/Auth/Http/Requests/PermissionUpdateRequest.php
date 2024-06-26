<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route()->id;
        return [
            'name' => ['required', 'string', 'unique:auth_permissions,name,' . $id . ',id'],
            'label' => ['required', 'string'],
            // 'guard_name' => ['required', Rule::in(['api'])],
            'bizapp_alias' => 'required|string',
            'is_active' => 'required|boolean',
            'child_permisson' => 'array',
            'child_permisson.*.name' => ['required', 'string'],
            'child_permisson.*.label' => ['required', 'string'],
            'child_permisson.*.is_active' => ['required', 'boolean'],

        ];
    }

    public function bodyParameters()
    {
        return [
            'name' => [
                'description' => 'Tên quyền',
                'example' => 'create-permission',
            ],
            'label' => [
                'description' => 'Tên hiển thị',
                'example' => 'Tạo mới permission',
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
