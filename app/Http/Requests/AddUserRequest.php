<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
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
        $this->session()->flash('add_user', true);
        return [
            'email' => 'required|email|unique:users,email',
            'name' => 'required',
            'username' => 'required',
            'password' => 'required|min:6|max:30',
            'confirm_password' => 'same:password',
            'level' => 'required|integer|min:1|max:2'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => trans('multi_language.validate.email_required'),
            'email.email' => trans('multi_language.validate.email_email'),
            'email.unique' => trans('multi_language.validate.email_unique'),
            'name.required' => trans('multi_language.validate.name_required'),
            'username.required' => trans('multi_language.validate.username_required'),
            'password.required' => trans('multi_language.validate.password_required'),
            'password.min' => trans('multi_language.validate.password_min'),
            'password.max' => trans('multi_language.validate.password_max'),
            'confirm_password.same' => trans('multi_language.validate.confirm_password_same'),
            'level.required' => trans('multi_language.validate.level_required'),
            'level.integer' => trans('multi_language.validate.level_integer'),
            'level.min' => trans('multi_language.validate.level_min'),
            'level.max' => trans('multi_language.validate.level_max')
        ];
    }
}
