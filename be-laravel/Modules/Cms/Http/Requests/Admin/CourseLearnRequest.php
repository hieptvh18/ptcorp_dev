<?php

namespace Modules\Cms\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CourseLearnRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_learns'=>'nullable|array',
            'course_learns.*.name'=>'required|string',
            'course_learns.*.id'=>'nullable|integer|exists:Modules\Cms\Models\CourseLearn,id',
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
