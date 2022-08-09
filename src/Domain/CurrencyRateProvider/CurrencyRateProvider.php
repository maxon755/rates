<?php

declare(strict_types=1);

namespace App\Domain;

interface CurrencyRateProvider
{
    public function getCurrencyRate(string $currency): float;
}
