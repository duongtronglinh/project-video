<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|min:6|max:30',
            'confirm_password' => 'same:password'
        ];
    }

    public function messages()
    {
        return [
            'password.required' => trans('multi_language.validate.password_required'),
            'password.min' => trans('multi_language.validate.password_min'),
            'password.max' => trans('multi_language.validate.password_max'),
            'confirm_password.same' => trans('multi_language.validate.confirm_password_same')
        ];
    }
}
