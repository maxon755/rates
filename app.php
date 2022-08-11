<?php

require 'vendor/autoload.php';

use App\BinListCountryResolver;
use App\Domain\CommissionCalculator;
use App\Domain\Money\Currency;
use App\Domain\Money\Money;
use App\Domain\Transaction;
use App\ExchangeRatesCurrencyConverter;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required('EXCHANGE_RATES_API_TOKEN');


$commissionCalculator = buildCommissionCalculator();

$commissionCalculator->calculateTransactionCommission(new Transaction(42424242, new Money(100, Currency::UAH)));

function buildCommissionCalculator(): CommissionCalculator
{
    $countryResolver = new BinListCountryResolver();
    $currencyConverter = new ExchangeRatesCurrencyConverter($_ENV['EXCHANGE_RATES_API_TOKEN']);

    return new CommissionCalculator($countryResolver, $currencyConverter);
}
