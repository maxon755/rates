<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\CountryResolver\CountryResolver;
use App\Domain\CurrencyConverter\CurrencyConverter;

class CommissionService
{
    private const EURO_COUNTRIES_COMMISSION_FRACTION = 0.1;
    private const NON_EURO_COUNTRIES_COMMISSION_FRACTION = 0.2;

    public function __construct(
        private CountryResolver $countryResolver,
        private CurrencyConverter $currencyConverter
    ) {
    }

    public function calculateTransactionCommission(Transaction $transaction): float
    {
        $country = $this->countryResolver->resolveCountryByBin($transaction->bin);

        $amount = $transaction->amount;
        if (!$transaction->isEuroCurrency()) {
            $amount = $this->currencyConverter->convertToEuro($amount, $transaction->currency);
        }

        $commissionFraction = $this->getCommissionFractionForCountry($country);

        return $amount * $commissionFraction;
    }

    private function getCommissionFractionForCountry(Country $country): float
    {
        return $country->isEuroCountry() ?
            self::EURO_COUNTRIES_COMMISSION_FRACTION :
            self::NON_EURO_COUNTRIES_COMMISSION_FRACTION;
    }
}
