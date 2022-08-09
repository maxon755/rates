<?php

declare(strict_types=1);

namespace App\Domain;

class Transaction
{
    public function __construct(
        public readonly int $bin,
        public readonly float $amount,
        public readonly string $currency,
    ) {
    }
}
