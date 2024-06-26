<?php

namespace Modules\Lms\Http\Requests;

use Illuminate\Validation\Rules\Enum;
use Modules\Lms\Enums\LmsUploadTypeEnum;
use Illuminate\Foundation\Http\FormRequest;

class LmsUploadRequest extends FormRequest
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
            'type' => ['required', new Enum(LmsUploadTypeEnum::class)],
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
