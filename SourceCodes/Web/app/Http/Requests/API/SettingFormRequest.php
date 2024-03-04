<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

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

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'statusCode'    => 400,
            'success'       => false,
            'message'       => $validator->errors()->first()
        ]));
    }
}
