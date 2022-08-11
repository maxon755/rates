<?php

declare(strict_types=1);

namespace App\Domain\Money;

class Money
{
    public readonly float $amount;

    public readonly Currency $currency;

    public function __construct(float $amount, Currency $currency)
    {
        if ($amount < 0) {
            throw new NegativeAmountException();
        }

        $this->amount = $amount;
        $this->currency = $currency;
    }
}
