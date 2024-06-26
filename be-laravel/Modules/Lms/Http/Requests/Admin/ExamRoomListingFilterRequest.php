<?php

namespace Modules\Lms\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ExamRoomListingFilterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ids'=>'nullable|array',
            'ids.*'=>'integer|exists:Modules\Lms\Models\ExamRoom,id',
            'name'=>'nullable|string|max:255',
            'author_ids'=>'nullable|array',
            'author_ids.*'=>'integer|exists:App\Models\User,id',
            'class_room_ids'=>'nullable|array',
            'class_room_ids.*'=>'integer|exists:Modules\Lms\Models\ClassRoom,id',
            'is_active'=>'nullable|boolean',
            'start_date'=>'nullable|date',
            'end_date'=>'nullable|date',
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
