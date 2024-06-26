<?php

namespace Modules\Lms\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ExamRoomUpdateRequest extends FormRequest
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
            'code'=>"nullable|string|max:255|unique:lms_exam_rooms,code,".$this->id,
            'subject_id'=>'required|integer',
            'exam_id'=>'required|integer',
            'exam_type'=>'nullable|in:RANDOM,SPECIFIC',
            'start_date'=>'required|date',
            'end_date'=>'nullable|date',
            'class_room_ids'=>'nullable|array',
            'class_room_ids.*'=>'integer|exists:Modules\Lms\Models\ClassRoom,id',
            'member_ids'=>'nullable|array',
            'member_ids.*'=>'integer|exists:Modules\Lms\Models\Member,id',
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
