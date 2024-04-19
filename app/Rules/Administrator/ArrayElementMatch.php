<?php

namespace App\Rules\Administrator;

use Illuminate\Contracts\Validation\Rule;

class ArrayElementMatch implements Rule
{
    protected $array;

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function passes($attribute, $value)
    {
        return in_array($value, $this->array);
    }

    public function message()
    {
        return 'La valeur sélectionnée pour :attribute est invalide.';
    }
}
