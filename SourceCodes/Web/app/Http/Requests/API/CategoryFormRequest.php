<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CategoryFormRequest extends FormRequest
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
                'name' => ['required', 'string', 'max:100', 'unique:categories']
            ];
        }
        if ($this->getMethod() === 'PUT') {
            $rules += [
                'name' => 'required|string|unique:categories,name,' . $this->id,
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
