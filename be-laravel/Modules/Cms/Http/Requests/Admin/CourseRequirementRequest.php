<?php

namespace Modules\Cms\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequirementRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_requirements'=>'nullable|array',
            'course_requirements.*.name'=>'required|string',
            'course_requirements.*.id'=>'nullable|integer|exists:Modules\Cms\Models\CourseRequirement,id',
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
