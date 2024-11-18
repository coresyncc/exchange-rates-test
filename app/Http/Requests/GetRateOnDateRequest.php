<?php

namespace App\Http\Requests;

use App\Rules\CurrencyCode;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetRateOnDateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'from' => ['required', new CurrencyCode()],
            'to' => ['required', new CurrencyCode()],
            'date' => ['required', 'date_format:Y-m-d'],
        ];
    }
}
