<?php

namespace Modules\Lms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassRoomUpdateRequest extends FormRequest
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
            'type' => 'required|in:CLASS,GROUP',
            'status' => 'required|in:PUBLISH,PRIVATE,CUSTOM',
            'is_active' => 'required|boolean',
            'school_year_id' => 'nullable|exists:lms_school_years,id'
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
