<?php

namespace App\Http\Requests;

use App\Models\Question;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'dateTime'  => ['nullable', 'date_format:Y-m-d H:i:s'],
            'comment'   => ['required', 'min:5', 'max:500'],
            'user_id'   => ['required', 'integer', 'exists:App\Models\User,id'],
	        'status'    => ['required', Rule::In(Question::$types)]
        ];
    }
}
