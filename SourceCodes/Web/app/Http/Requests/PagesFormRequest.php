<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Recaptcha;

class PagesFormRequest extends FormRequest
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
            'g-recaptcha-response' => ['required', new Recaptcha()],
            'name'      => 'required|string|max:30',
            'email'     => 'required|string|email|regex:/(.+)@(.+)\.(.+)/i',
            'phone_no'  => 'required|max:14|min:10|regex:/^([0-9\s\-\+\(\)]*)$/',
            'queries'   => 'required',
        ];
    }
}
