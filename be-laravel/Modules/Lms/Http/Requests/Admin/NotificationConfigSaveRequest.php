<?php

namespace Modules\Lms\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Modules\Lms\Enums\NotificationConfigTypeEnum;

class NotificationConfigSaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description'=>'required|string',
            'file_attach_url'=>'nullable|string',
            'link_attach_url'=>'nullable|string',
            'published_at'=>'required|date',
            'type' => ['string', new Enum(NotificationConfigTypeEnum::class)],
            'type_options'=>'nullable|array',
            'type_option_advanceds'=>'nullable|array',
            'is_active' => 'required|boolean'
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

    public function attributes(){
        return [
          'file_attach_url'=>"File đính kèm",
          'link_attach_url'=>"Link đính kèm",
          'published_at'=>"Ngày đăng",
          'type'=>"Chế độ hiển thị",
          'type_options'=>"Hiển thị với",
          'type_option_advanceds'=>"Đồng thời hiển thị với",
        ];
    }
}
