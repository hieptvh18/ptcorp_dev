<?php

namespace Modules\Cms\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CmsReviewSaveRequest extends FormRequest
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
            'rating'=>'required|integer',
            'customer_service_rating'=>"nullable|integer",
            'quality_rating'=>"nullable|integer",
            'friendly_rating'=>'nullable|integer',
            'pricing_rating'=>'nullable|integer',
            'recommend'=>'nullable|in:Yes,No',
            'department'=>'nullable|in:Sales,Service,Parts',
            'title'=>'required|string|max:255',
            'body'=>'nullable|string',
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
