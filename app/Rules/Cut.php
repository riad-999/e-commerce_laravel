<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Cut implements Rule
{
    public $code;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach ($this->code->cuts as $cut) {
            if ($cut->cut == $value) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'cette réduction exists déja';
    }
}