<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingFormRequest extends FormRequest
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
        $rules = [];

        if ($this->getMethod() === 'POST') {
            $rules += [
                'description.*'     => 'required',
                'banner_image.*'    => 'required|image|mimes:jpeg,png,jpg,gif'
            ];
        }
        if ($this->getMethod() === 'PUT') {
            $rules += [
                'description'   => 'required',
                'banner_image'  => 'image|mimes:jpeg,png,jpg,gif'
            ];
        }
        return $rules;
    }
}
