<?php

namespace Modules\Cms\Http\Requests;

use Illuminate\Validation\Rules\Enum;
use Modules\Cms\Enums\UploadTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => ['required', 'file'],
            'type' => ['required', new Enum(UploadTypeEnum::class)],
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
