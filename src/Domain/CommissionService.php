<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\CountryResolver\CountryResolver;

class CommissionService
{
    public function __construct(
        private CountryResolver $countryResolver,
        private CurrencyRateProvider $currencyRateProvider
    ) {

    }

    public function calculateTransactionCommission(Transaction $transaction): int
    {
        return 42;
    }
}
