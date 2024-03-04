<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class TicketFormRequest extends FormRequest
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
                'ticket_title.*'  => ['required', 'max:100'],
                'event_id'        => ['required'],
                'ticket_type.*'   => ['required'],
                'total_qty.*'     => ['required'],
                'end_date.*'      => ['required'],
                'end_time.*'      => ['required'],
            ];
        }
        if ($this->getMethod() === 'PUT') {
            $rules += [
                'ticket_title'  => ['required', 'max:100'],
                // 'event_id'      => ['required'],
                'ticket_type'   => ['required'],
                'total_qty'     => ['required'],
                'end_date'      => ['required'],
                'end_time'      => ['required'],
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
