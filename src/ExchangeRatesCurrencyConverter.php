<?php

declare(strict_types=1);

namespace App;

use App\Domain\CurrencyConverter\CurrencyConverter;

class ExchangeRatesCurrencyConverter implements CurrencyConverter
{

    public function convertToEuro(float $amount, string $currency): float
    {
        return 42.42;
    }
}
