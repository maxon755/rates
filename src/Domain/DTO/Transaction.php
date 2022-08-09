<?php

declare(strict_types=1);

namespace App\Domain;

class Transaction
{
    public readonly int $bin;

    public readonly float $amount;

    public readonly string $currency;
}
