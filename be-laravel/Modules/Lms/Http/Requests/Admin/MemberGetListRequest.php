<?php

namespace Modules\Lms\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MemberGetListRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'outside-classes' => 'nullable|array|exists:Modules\Lms\Models\ClassRoom,id',
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
