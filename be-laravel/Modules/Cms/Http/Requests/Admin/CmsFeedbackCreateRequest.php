<?php

namespace Modules\Cms\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CmsFeedbackCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|string|max:255',
              'description'=> 'required|string',
              'student_name'=>'required|string|max:255',
              'student_avatar_url'=>'nullable|string|max:255',
              'type'=>'required|in:COURSE',
              'sort_order'=>'integer|nullable'
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
