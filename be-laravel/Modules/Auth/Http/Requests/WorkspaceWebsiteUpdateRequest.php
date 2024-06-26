<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkspaceWebsiteUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'workspace_alias' => 'required|string|exists:auth_workspace_info,alias',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'slogan' => 'required|string',
            'logo_url' => 'required|string',
            'favicon' => 'nullable|string',
            'email' => 'required|string',
            'is_active' => 'required|boolean'
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
