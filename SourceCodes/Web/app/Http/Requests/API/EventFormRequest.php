<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class EventFormRequest extends FormRequest
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
            'event_title'       => 'required|max:100',
            'category_id'       => 'required',
            'organizer'         => 'required|max:50',
            'venue'             => 'required|max:100',
            'address'           => 'required',
            'city'              => 'required|max:30',
            'zipcode'           => 'required|max:10',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after_or_equal:start_date',
            'start_time'        => 'required',
            'end_time'          => 'required',
            'description'       => 'required',
            'image'             => 'image|mimes:jpeg,png,jpg,gif',
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
