<?php

namespace App\Http\Requests\Auth;

use App\Models\Auth\Country;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

class AddCountryRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            // 'name' => 'required|string|unique:countries,name',
            'name' => [
                'required',
                'string', 'unique:countries,name',
                function (string $attribute, mixed $value, Closure $fail) {
                    $guarantees = Country::count();

                    if ($guarantees >= decrypt(config('bls.countries.limit'))) {
                        $fail("The countries limit is reached.");
                    }
                    // if ( Carbon::parse($value) < Carbon::parse($guarantee->current_task->max_deadline)) {
                    //     $fail("The {$attribute} is invalid.");
                    // }
                },
            ]
        ];
    }
}
