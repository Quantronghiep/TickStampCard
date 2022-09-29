<?php

namespace App\Http\Requests;

use App\Rules\NumberCouponRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'number_accumulation' => ['required', new NumberCouponRule()] ,
            'note_using' => 'max:255'
        ];
    }
}
