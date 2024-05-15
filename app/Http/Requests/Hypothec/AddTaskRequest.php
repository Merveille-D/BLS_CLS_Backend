<?php

namespace App\Http\Requests\Hypothec;

use App\Models\Guarantee\ConvHypothec;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddTaskRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        // Add the 'modele' attribute to the request input
        $this->merge([
            'modele' => 'conv_hypothec',
        ]);
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'model_id' => 'required|exists:conv_hypothecs,id',
            'deadline' => [
                'required',
                'date', 'date_format:Y-m-d',
                function (string $attribute, mixed $value, Closure $fail) {
                    $hypothec = ConvHypothec::find(request('model_id'));
                    if ( Carbon::parse($value) <= Carbon::parse($hypothec->current_task->max_deadline)) {
                        $fail("The {$attribute} is invalid.");
                    }
                },
            ]
        ];
    }


    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['success' => false, 'message' => $validator->errors()->first(), 'errors' => $validator->errors()], 422));
    }
}
