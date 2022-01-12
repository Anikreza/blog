<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SaveProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|min:2|max:30',
            'last_name' => 'required|min:2|max:30',
            'gender' => 'required',
            'd_o_b' => 'required',
            'avatar' => 'nullable|image',
            'street' => 'required',
            'street_number' => 'required',
            'city' => 'required',
            'postcode' => 'required',
            'country_id' => 'required',
            'country_code' => 'required',
            'mobile_number' => 'required',
        ];
    }
}
