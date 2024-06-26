<?php

namespace Modules\Common\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'flag' => 'required|string',
            'name' => 'required|string|unique:common_countries,name,NULL,id,deleted_at,NULL',
            'code' => 'required|string|unique:common_countries,code,NULL,id,deleted_at,NULL|regex:/^[a-zA-Z0-9_]+$/',
            'postal_code' => 'nullable|string',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
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
