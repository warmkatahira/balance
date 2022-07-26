<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BalanceRegisterRequest extends FormRequest
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
            'balance_base_id' => [Rule::unique('balances')->where('balance_base_id', $request->balance_base_id)->where('balance_date', $request->balance_date)],
        ];
    }

    public function messages()
    {
        return [
            'balance_base_id' => 'aaaa',
        ];
    }
}
