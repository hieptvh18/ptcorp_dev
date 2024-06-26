<?php

namespace Modules\Notification\Http\Requests;

use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;
use Modules\Notification\Enums\CampainStatusEnum;

class CampainUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|unique:notification_campains,name,' .$this->id,
            'status' => ['required', new Enum(CampainStatusEnum::class)],
            'content' => 'required',
            'published_at' => 'required'
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
