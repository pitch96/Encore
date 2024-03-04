<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegistrationFormRequest extends FormRequest
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
            'first_name'            => ['required', 'string', 'max:255'],
            'last_name'             => ['required', 'string', 'max:255'],
            'phone_no'              => 'required|max:14|min:10|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email'                 => 'required|string|email|unique:users|regex:/(.+)@(.+)\.(.+)/i',
            'password'              => ['required', 'string', 'min:6', 'max:50', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:6', 'max:50'],
        ];
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
