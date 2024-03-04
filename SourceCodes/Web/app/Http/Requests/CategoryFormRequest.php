<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

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
                'name' => ['required', 'string', 'min:3', 'max:30', 'unique:categories', 'regex:/^[a-zA-Z]+$/u']
            ];
        }
        if ($this->getMethod() === 'PUT') {
            $rules += [
                'name' => 'required|string|min:3|max:30|regex:/^[a-zA-Z]+$/u|unique:categories,name,' . Crypt::decrypt($this->id),
            ];
        }
        return $rules;
    }   
}
