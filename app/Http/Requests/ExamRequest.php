<?php

namespace App\Http\Requests;

use App\Rules\OneMustSelected;
use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
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
            "title" => 'required',
            "start_date" => "nullable|date_format:Y-m-d\TH:i|after_or_equal:now",
            "end_date" => "nullable|date_format:Y-m-d\TH:i|after_or_equal:now|after:start_date",
            "selections_size" => "required|numeric|min:2|max:6",
            "questions" => "required|array",
            "questions.*.context" => "required",
            "questions.*.selections.*.context" => "required",
            "questions.*.selections.*.selected" => "required|boolean",
            "questions.*.selections" => ["bail", "required", "array", "min:2", "max:6", new OneMustSelected],
        ];
    }
}
