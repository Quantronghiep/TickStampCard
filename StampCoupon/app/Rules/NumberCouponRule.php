<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Stamp;
class NumberCouponRule implements Rule
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


    public function passes($attribute, $value)
    {
       $stamp = new Stamp();
        return $value < $stamp->numberMaxStamp();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $stamp = new Stamp();
        return "The :attribute must be <= " . $stamp->numberMaxStamp() ;
    }
}
