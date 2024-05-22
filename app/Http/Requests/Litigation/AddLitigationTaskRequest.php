<?php

namespace App\Http\Requests\Litigation;

use App\Models\Guarantee\Guarantee;
use App\Models\Litigation\Litigation;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddLitigationTaskRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        // Add the 'modele' attribute to the request input
        $this->merge([
            'modele' => 'litigation',
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
            'model_id' => 'required|exists:litigations,id',
            // 'deadline' => 'required|date|date_format:Y-m-d',
            'deadline' => [
                'required',
                'date', 'date_format:Y-m-d',
                function (string $attribute, mixed $value, Closure $fail) {
                    $litigation = Litigation::find(request('model_id'));
                    // dd($litigation->current_task->completed_at, Carbon::parse($value));
                    if ( Carbon::parse($value) < Carbon::parse($litigation->current_task->completed_at)) {
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
