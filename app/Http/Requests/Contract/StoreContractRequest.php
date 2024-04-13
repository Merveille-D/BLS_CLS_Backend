<?php

namespace App\Http\Requests\Contract;

use App\Models\Contract\Contract;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreContractRequest extends FormRequest
{
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
    public function rules(Request $request): array
    {
        $rules = [
            'title' => ['required', 'string'],
            'category' => ['required',  Rule::in(Contract::CATEGORIES) ],
            'type_category' => [ Rule::in(Contract::TYPE_CATEGORIES[$request->input('category')]) ],
            'contract_file' => ['required', 'file'],

            // 'first_part' => ['required', 'array'],
            // 'first_part.*.part_id' => ['required', 'uuid', 'exists:parts,id'],
            // 'first_part.*.description' => ['required', 'string'],
            // 'second_part' => ['required', 'array'],
            // 'second_part.*.part_id' => ['required', 'uuid', 'exists:parts,id'],
            // 'second_part.*.description' => ['required', 'string'],

            'first_part' => ['required', 'array'],
            'first_part.*.part_id' => [
                'required',
                'uuid',
                'exists:parts,id',
                function ($attribute, $value, $fail) {
                    $secondPartData = request()->input('second_part');

                    foreach ($secondPartData as $item) {
                        if ($item['part_id'] === $value) {
                            $fail('Le part_id ne peut pas être présent à la fois dans first_part et second_part');
                        }
                    }
                },
            ],
            'first_part.*.description' => ['required', 'string'],

            
            'second_part' => ['required', 'array'],
            'second_part.*.part_id' => [
                'required',
                'uuid',
                'exists:parts,id',
                function ($attribute, $value, $fail) {
                    $firstPartData = request()->input('first_part');

                    foreach ($firstPartData as $item) {
                        if ($item['part_id'] === $value) {
                            $fail('Le part_id ne peut pas être présent à la fois dans first_part et second_part');
                        }
                    }
                },
            ],
            'second_part.*.description' => ['required', 'string'],

        ];

        return $rules;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $validator->errors()->first(),
            'errors' => $validator->errors()
        ], 422));
    }
}
