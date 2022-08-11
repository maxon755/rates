<?php

use App\BinListCountryResolver;
use App\Domain\CommissionCalculator;
use App\ExchangeRatesCurrencyConverter;

$commissionCalculator = buildCommissionCalculator();

function buildCommissionCalculator(): CommissionCalculator
{
    $countryResolver = new BinListCountryResolver();
    $currencyConverter = new ExchangeRatesCurrencyConverter();

    return new CommissionCalculator($countryResolver, $currencyConverter);
}
