<?php

declare(strict_types=1);

namespace App\Domain\CurrencyConverter;

use App\Domain\Money\Money;

interface CurrencyConverter
{
    public function convertToEuro(Money $moneyFrom): Money;
}
