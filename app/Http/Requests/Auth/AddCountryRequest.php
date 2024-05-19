<?php

namespace App\Http\Requests\Auth;

use App\Models\Auth\Country;
use App\Models\Auth\Subsidiary;
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
            'address' => 'required|string',
            'country' => 'required|string',
            'name' => [
                'required',
                'string', 'unique:subsidiaries,name',
                function (string $attribute, mixed $value, Closure $fail) {
                    $subsidiaries = Subsidiary::count();

                    if ($subsidiaries >= (config('bls.countries.limit'))) {
                        $fail("The subsidiaries limit is reached.");
                    }
                    // if ( Carbon::parse($value) < Carbon::parse($guarantee->current_task->max_deadline)) {
                    //     $fail("The {$attribute} is invalid.");
                    // }
                },
            ]
        ];
    }
}
