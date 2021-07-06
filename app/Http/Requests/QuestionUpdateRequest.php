<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionUpdateRequest extends FormRequest
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
//            'name'      => ['required', 'max:50'],
//            'email'     => ['required', 'email', 'min:5', 'max:100'],
//            'message'   => ['required', 'min:5', 'max:2000'],
            // только зарегастрированный пользователь
//            'status'    => ['required', Rule::In(Question::$types)],
            'dateStart' => ['nullable', 'date'],
            'comment' => ['required', 'min:5', 'max:500'],
            'user_id' => ['required', 'integer']
        ];
    }
}
