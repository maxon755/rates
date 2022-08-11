<?php

declare(strict_types=1);

namespace App\Domain\Money;

class Euro extends Money
{
    public function __construct(float $amount)
    {
        parent::__construct($amount, Currency::EUR);
    }
}
