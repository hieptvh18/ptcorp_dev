<?php

namespace Modules\Lms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassRoomCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'classrooms' => 'required|array',
            'classrooms.*.name' => 'required|string|min:3|max:255',
            'classrooms.*.type' => 'required|in:CLASS,GROUP',
            'classrooms.*.status' => 'required|in:PUBLISH,PRIVATE,CUSTOM',
            'classrooms.*.is_active' => 'required|boolean',
            'classrooms.*.child_classrooms' => 'array',
            'classrooms.*.child_classrooms.*.name' => 'string|min:3|max:255',
            'classrooms.*.child_classrooms.*.type' => 'in:CLASS,GROUP',
            'classrooms.*.child_classrooms.*.status' => 'in:PUBLISH,PRIVATE,CUSTOM',
            'classrooms.*.child_classrooms.*.is_active' => 'boolean',
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
