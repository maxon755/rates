<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\CountryResolver\CountryResolver;
use App\Domain\CurrencyConverter\CurrencyConverter;
use App\Domain\Money\Euro;
use App\Domain\Money\Money;

class CommissionCalculator
{
    private const EURO_COUNTRIES_COMMISSION_FRACTION = 0.01;
    private const NON_EURO_COUNTRIES_COMMISSION_FRACTION = 0.02;

    public function __construct(
        private CountryResolver $countryResolver,
        private CurrencyConverter $currencyConverter
    ) {
    }

    public function calculateTransactionCommission(Transaction $transaction): Money
    {
        $country = $this->countryResolver->resolveCountryByBin($transaction->bin);

        $money = $transaction->money;
        if (!$money->currency->isEuro()) {
            $money = $this->currencyConverter->convertToEuro($transaction->money);
        }

        $commissionFraction = $this->getCommissionFractionForCountry($country);
        $commissionAmount = $money->amount * $commissionFraction;
        $commissionAmount = $this->roundUp($commissionAmount, 2);

        return new Euro($commissionAmount);
    }

    private function roundUp(float $value, int $precision): float
    {
        $pow = 10 ** $precision;

        return (ceil($pow * $value) + ceil($pow * $value - ceil($pow * $value))) / $pow;
    }

    private function getCommissionFractionForCountry(Country $country): float
    {
        return $country->isEUCountry() ?
            self::EURO_COUNTRIES_COMMISSION_FRACTION :
            self::NON_EURO_COUNTRIES_COMMISSION_FRACTION;
    }
}
