<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\CountryResolver\CountryResolver;
use App\Domain\CurrencyConverter\CurrencyConverter;

class CommissionCalculator
{
    private const EURO_COUNTRIES_COMMISSION_FRACTION = 0.01;
    private const NON_EURO_COUNTRIES_COMMISSION_FRACTION = 0.02;

    public function __construct(
        private CountryResolver $countryResolver,
        private CurrencyConverter $currencyConverter
    ) {
    }

    public function calculateTransactionCommission(Transaction $transaction): float
    {
        $country = $this->countryResolver->resolveCountryByBin($transaction->bin);

        $money = $transaction->money;
        if (!$money->currency->isEuro()) {
            $money = $this->currencyConverter->convertToEuro($transaction->money);
        }

        $commissionFraction = $this->getCommissionFractionForCountry($country);

        return $money->amount * $commissionFraction;
    }

    private function getCommissionFractionForCountry(Country $country): float
    {
        return $country->isEUCountry() ?
            self::EURO_COUNTRIES_COMMISSION_FRACTION :
            self::NON_EURO_COUNTRIES_COMMISSION_FRACTION;
    }
}
