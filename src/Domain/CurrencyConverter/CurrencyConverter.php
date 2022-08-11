<?php

declare(strict_types=1);

namespace App\Domain\CurrencyConverter;

use App\Domain\Money\Money;

interface CurrencyConverter
{
    /**
     * @param Money $moneyFrom
     * @return Money
     *
     * @throws CurrencyConverterException
     */
    public function convertToEuro(Money $moneyFrom): Money;
}
