<?php

declare(strict_types=1);

namespace App\Domain\Money;

class Money
{
    public function __construct(
        public readonly float $amount,
        public readonly Currency $currency,
    )
    {
    }
}
