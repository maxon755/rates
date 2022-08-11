<?php

declare(strict_types=1);

namespace App;

use App\Domain\CurrencyConverter\CurrencyConverter;
use App\Domain\Money\Currency;
use App\Domain\Money\Money;

class ExchangeRatesCurrencyConverter implements CurrencyConverter
{
    public function __construct(private readonly string $apiToken)
    {
    }


    public function convertToEuro(Money $moneyFrom): Money
    {
        return new Money(42.42, Currency::EUR);
    }
}
