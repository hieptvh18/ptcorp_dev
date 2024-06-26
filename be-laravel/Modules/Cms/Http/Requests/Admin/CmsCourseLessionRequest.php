<?php

namespace Modules\Cms\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CmsCourseLessionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_id'=>'required|exists:Modules\Cms\Models\Course,id',
            'section_id'=>'required|exists:Modules\Cms\Models\CourseSection,id',
            'name'=>'required|string|max:255',
            'description'=>'nullable|string',
            'preview_video_url'=>"nullable|string",
            'duration'=>'required|integer'
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
