<?php

declare(strict_types=1);

use App\Domain\Money\Currency;
use PHPUnit\Framework\TestCase;

class CurrencyUnitTest extends TestCase
{
    /**
     * @test
     */
    public function it_determines_euro_currency()
    {
        $this->assertTrue(Currency::EUR->isEuro());
    }

    /**
     * @test
     */
    public function it_determines_non_euro_currency()
    {
        $this->assertFalse(Currency::UAH->isEuro());
    }
}
