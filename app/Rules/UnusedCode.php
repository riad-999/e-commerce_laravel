<?php

namespace App\Rules;

use App\Models\PromoCode;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UnusedCode implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($user_id, $code)
    {
        $this->user_id = $user_id;
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
        $code_id = PromoCode::get_by_code($this->code)->id;
        $used = DB::table('promo_user')->where('user_id', '=', $this->user_id)
            ->where('promo_code_id', '=', $code_id)->first();
        if ($used)
            return false;
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'vous avez déja utiliser ce code promo';
    }
}