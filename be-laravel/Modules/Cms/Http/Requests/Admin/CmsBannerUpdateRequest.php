<?php

namespace Modules\Cms\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Modules\Cms\Enums\CmsBannerTypeEnum;

class CmsBannerUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $type = $this->input('type');
        return [
            "name" => "required|max:255",
            "type" => ["required", new Enum(CmsBannerTypeEnum::class)],
            'image_url' => "string|nullable|required_if:type,==,IMAGE|max:255",
            "video_url" => "string|nullable|required_if:type,==,VIDEO|max:255",
            "link_redirect" => "string|nullable|max:255",
            "position" => "required|in:HOMEPAGE_COURSE",
            "start_date" => "required|date",
            "end_date" => "date|nullable",
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
