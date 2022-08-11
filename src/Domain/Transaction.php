<?php

declare(strict_types=1);

namespace App\Domain;

use App\Domain\Money\Money;

class Transaction
{
    public function __construct(
        public readonly int $bin,
        public readonly Money $money
    ) {
    }
}
