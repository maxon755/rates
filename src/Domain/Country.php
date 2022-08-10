<?php

declare(strict_types=1);

namespace App\Domain;

class Country
{
    private const EURO_COUNTRY_CODES = [
        'AT',
        'BE',
        'BG',
        'CY',
        'CZ',
        'DE',
        'DK',
        'EE',
        'ES',
        'FI',
        'FR',
        'GR',
        'HR',
        'HU',
        'IE',
        'IT',
        'LT',
        'LU',
        'LV',
        'MT',
        'NL',
        'PO',
        'PT',
        'RO',
        'SE',
        'SI',
        'SK',
    ];

    public function __construct(
        public readonly string $code
    ) {
    }

    public function isEUCountry(): bool
    {
        return \in_array($this->code, self::EURO_COUNTRY_CODES, true);
    }
}
