<?php

namespace Modules\Cms\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CmsBlogTagUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255|unique:lms_cms_blog_tags,name,' . $this->id,
            'is_active' => 'required',
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
