<?php

namespace Modules\Lms\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SubjectSaveRequest extends FormRequest
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
            'description'=>'nullable|string',
            'avatar_url'=>'nullable|string|max:255',
            'teacher_ids'=>'nullable|array',
            'teacher_ids.*'=>'integer|exists:Modules\Lms\Models\Member,id',
            'level_school_ids'=>'nullable|array',
            'level_school_ids.*'=>'integer|exists:mysql.quiz_level_schools,id',
            'is_active'=>"nullable|boolean"
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
