<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'regex:/^[a-z0-9_-]+$/'],
            'label' => ['required', 'string'],
            // 'guard_name' => ['required', Rule::in(['api'])],
            'bizapp_alias' => 'required|string',
            'is_active' => 'required|boolean',
            'child_permisson' => 'array',
            'child_permisson.*.name' => ['required', 'string', 'regex:/^[a-z0-9_-]+$/'],
            'child_permisson.*.label' => ['required', 'string'],
            'child_permisson.*.is_active' => ['required', 'boolean'],
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
