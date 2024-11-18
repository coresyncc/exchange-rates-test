<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class CurrencyCode implements ValidationRule
{
    protected array $valid_currencies = [
        'AUD', 'AZN', 'AMD', 'BYN', 'BGN', 'BRL', 'HUF', 'KRW', 'VND',
        'HKD', 'GEL', 'DKK', 'AED', 'USD', 'EUR', 'EGP', 'INR', 'IDR',
        'KZT', 'CAD', 'QAR', 'KGS', 'CNY', 'MDL', 'NZD', 'TMT', 'NOK',
        'PLN', 'RON', 'XDR', 'RSD', 'SGD', 'TJS', 'THB', 'TRY', 'UZS',
        'UAH', 'GBP', 'CZK', 'SEK', 'CHF', 'ZAR', 'JPY', 'RUB'
    ];

    /**
     * Run the validation rule.
     *
     * @param Closure(string, ?string=): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array(strtoupper($value), $this->valid_currencies)) {
            $fail('The :attribute must be a valid currency code.');
        }
    }
}
