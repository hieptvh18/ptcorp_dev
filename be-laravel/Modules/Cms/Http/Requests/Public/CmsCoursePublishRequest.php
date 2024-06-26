<?php

namespace Modules\Cms\Http\Requests\Public;

use Illuminate\Foundation\Http\FormRequest;

class CmsCoursePublishRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'price_type'=>'nullable|in:free,paid,all',
            'category_id' => 'nullable|exists:Modules\Cms\Models\CmsCategory,id',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:Modules\Cms\Models\CmsCategory,id',
            'level_ids' => 'nullable|array',
            'level_ids.*' => 'exists:Modules\Cms\Models\CourseLevel,id',
            'instructor_ids' => 'nullable|array',
            'instructor_ids.*' => 'exists:Modules\Cms\Models\CourseInstructor,id',
            'language_ids' => 'nullable|array',
            'language_ids' => 'exists:Modules\Cms\Models\CourseLanguage,id',
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
