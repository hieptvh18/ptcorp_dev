<?php

namespace Modules\Cms\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Modules\Cms\Enums\CmsCourseStatusEnum;
use Modules\Cms\Enums\CmsCourseTypeEnum;

class CourseUpdateRequest extends FormRequest
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
            'short_description'=>"nullable|max:255",
            'description'=>'nullable|string',
            'regular_price'=>"required|numeric|digits_between:0,10",
            'sale_price'=>"nullable|numeric|digits_between:0,10",
            'preview_video_url'=>'nullable|string|max:255',
            'preview_video_type'=> 'nullable|in:YOUTUBE,VIDEO',
            'avatar_url'=>'required|string|max:255',
            'total_duration'=>"nullable|integer",
            'type'=>['required', new Enum(CmsCourseTypeEnum::class)],
            'address'=>'nullable|string',
            'status'=>['required', new Enum(CmsCourseStatusEnum::class)],
            'instructor_ids'=>'required|array',
            'instructor_ids.*'=>'integer|exists:Modules\Cms\Models\CourseInstructor,id',
            'category_ids'=>'required|array',
            'category_ids.*'=>'integer|exists:Modules\Cms\Models\CmsCategory,id',
            'level_ids'=>'required|array',
            'level_ids.*'=>'integer|exists:Modules\Cms\Models\CourseLevel,id',
            'language_ids'=>'nullable|array',
            'language_ids.*'=>'integer|exists:Modules\Cms\Models\CourseLanguage,id',
            "start_date" => "required|date",
            "end_date" => "nullable|date",
            'schedule_days'=>"nullable|array"
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

    public function messages()
    {
        return [
            'regular_price.digits'=>'Giá gốc không thể lớn hơn :digits chữ số.',
            'sale_price.digits'=>'Giá bán không thể lớn hơn :digits chữ số.'
        ];
    }

    public function attributes()
    {
        return [
            'short_description'=>"Mô tả ngắn",
            'description'=>'Mô tả',
            'regular_price'=>"Giá gốc",
            'sale_price'=>"Giá bán",
            'preview_video_url'=>'Video xem trước',
            'avatar_url'=>'Ảnh đại diện',
            'address'=>'Địa chỉ',
            'status'=>'Trạng thái',
            'instructor_ids'=>'Giảng viên',
            'category_ids'=>'Danh mục',
            'level_ids'=>'Trình độ',
            "start_date" => "Ngày kết thúc",
            "end_date" => "Ngày kết thúc",
            'schedule_days'=>"Lịch học"
        ];
    }
}
