<?php

namespace Modules\Common\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DistrictUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|string|unique:common_districts,code,' . $this->item . ',id,deleted_at,NULL|regex:/^[a-zA-Z0-9_]+$/',
            'name' => 'required|string|unique:common_districts,name,' . $this->item . ',id,deleted_at,NULL',
            'country_id' => 'required|integer|exists:common_countries,id,deleted_at,NULL',
            'province_id' => 'required|integer|exists:common_provinces,id,deleted_at,NULL',
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
