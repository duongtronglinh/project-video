<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddVideoRequest extends FormRequest
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
            'video_name' => 'required',
            'thumbnail_picture' => 'required|mimes:jpeg,bmp,png',
            'video_file' => 'required|mimes:mp4,3gp'
        ];
    }

    public function messages()
    {
        return [
            'video_name.required' => trans('multi_language.validate.video_name_required'),
            'thumbnail_picture.required' => trans('multi_language.validate.thumbnail_required'),
            'thumbnail_picture.mimes' => trans('multi_language.validate.thumbnail_format'),
            'video_file.required' => trans('multi_language.validate.video_file_required'),
            'video_file.mimes' => trans('multi_language.validate.video_format')
        ];
    }
}
