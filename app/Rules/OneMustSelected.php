<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OneMustSelected implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $selections)
    {
        return collect($selections)->filter(function ($selection) {
            return isset($selection["selected"]) ? $selection["selected"] : false;
        })->count() == 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'One selection must be selected.';
    }
}
