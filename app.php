<?php

require 'vendor/autoload.php';

use App\BinListCountryResolver;
use App\Domain\CommissionCalculator;
use App\ExchangeRatesCurrencyConverter;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required('EXCHANGE_RATES_API_TOKEN');


$commissionCalculator = buildCommissionCalculator();

function buildCommissionCalculator(): CommissionCalculator
{
    $countryResolver = new BinListCountryResolver();
    $currencyConverter = new ExchangeRatesCurrencyConverter();

    return new CommissionCalculator($countryResolver, $currencyConverter);
}
