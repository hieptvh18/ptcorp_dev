<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkspaceInfoUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'short_name' => 'required|string|min:3|max:20|regex:/^([a-zA-Z0-9]*)$/|unique:auth_workspace_info,short_name,' .$this->id,
            'mobile' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:11',
            'email' => 'nullable|email|unique:auth_workspace_info,email',
            'address' => 'nullable|string',
            'description' => 'nullable|string|min:3',
            'avatar_url' => 'required|string',
            'background_image_url' => 'nullable|string',
            'website' => 'nullable|string',
            'founded_date' => 'nullable|date',
            'level_school_ids' => 'array',
            'level_school_ids.*' => 'integer|exists:quiz_level_schools,id'
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
