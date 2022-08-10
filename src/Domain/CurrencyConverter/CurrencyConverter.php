<?php

declare(strict_types=1);

namespace App\Domain\CurrencyConverter;

interface CurrencyConverter
{
    public function convertToEuro(float $amount, string $currency): float;
}
