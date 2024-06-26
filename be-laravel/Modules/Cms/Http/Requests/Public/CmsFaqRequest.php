<?php

namespace Modules\Cms\Http\Requests\Public;

use Illuminate\Foundation\Http\FormRequest;

class CmsFaqRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'faq_category_id'=>'nullable|exists:Modules\Cms\Models\FaqCategory,id',
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
