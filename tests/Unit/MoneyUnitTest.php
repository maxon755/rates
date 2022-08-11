<?php

declare(strict_types=1);

use App\Domain\Money\Currency;
use App\Domain\Money\Money;
use App\Domain\Money\NegativeAmountException;
use PHPUnit\Framework\TestCase;

class MoneyUnitTest extends TestCase
{
    public function amount_cant_be_negative()
    {
        $this->expectException(NegativeAmountException::class);

        new Money(-42.0, Currency::EUR);
    }
}
