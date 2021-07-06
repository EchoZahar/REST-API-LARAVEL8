<?php

namespace App\Http\Requests;

use App\Models\Question;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterRequest extends FormRequest
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
     * без констант прописаных в модели можно использовать 'nullable|in:active,resolved')
     */
    public function rules()
    {
        return [
            'status' => ['nullable', Rule::In(Question::$types)],
            'dateStart' => 'nullable|date|date_format:Y-m-d',
            'dateEnd' => 'nullable|date|date_format:Y-m-d'
        ];
    }
}
