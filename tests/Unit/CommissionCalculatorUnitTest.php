<?php

declare(strict_types=1);

use App\Domain\CommissionCalculator;
use App\Domain\Country;
use App\Domain\CountryResolver\CountryResolver;
use App\Domain\CurrencyConverter\CurrencyConverter;
use App\Domain\Transaction;
use PHPUnit\Framework\TestCase;

class CommissionCalculatorUnitTest extends TestCase
{
    private CountryResolver $countryResolver;
    private CurrencyConverter $currencyConverter;
    private CommissionCalculator $commissionCalculator;

    protected function setUp(): void
    {
        $this->countryResolver = $this->createMock(CountryResolver::class);
        $this->currencyConverter = $this->createMock(CurrencyConverter::class);

        $this->commissionCalculator = new CommissionCalculator($this->countryResolver, $this->currencyConverter);
    }

    /**
     * @test
     */
    public function it_can_calculate_commission_for_euro_credit_card(): void
    {
        $transaction = new Transaction(
            4242,
            100.00,
            'EUR'
        );

        $this->countryResolver->expects($this->once())
            ->method('resolveCountryByBin')
            ->with($transaction->bin)
            ->willReturn(new Country('FR'));

        $this->currencyConverter
            ->expects($this->never())
            ->method('convertToEuro');

        $commission = $this->commissionCalculator->calculateTransactionCommission($transaction);

        $this->assertEquals(1, $commission);
    }

    /**
     * @test
     */
    public function it_can_calculate_commission_for_non_euro_credit_card(): void
    {
        $transaction = new Transaction(
            4242,
            100.00,
            'EUR'
        );

        $this->countryResolver->expects($this->once())
            ->method('resolveCountryByBin')
            ->with($transaction->bin)
            ->willReturn(new Country('UA'));

        $this->currencyConverter
            ->expects($this->never())
            ->method('convertToEuro');

        $commission = $this->commissionCalculator->calculateTransactionCommission($transaction);

        $this->assertEquals(2, $commission);
    }

    /**
     * @test
     */
    public function it_can_calculate_commission_for_non_euro_currency(): void
    {
        $transaction = new Transaction(
            4242,
            4000.00,
            'UAH'
        );

        $this->countryResolver->expects($this->once())
            ->method('resolveCountryByBin')
            ->with($transaction->bin)
            ->willReturn(new Country('UA'));

        $this->currencyConverter
            ->expects($this->once())
            ->method('convertToEuro')
            ->willReturn(100.00)
        ;

        $commission = $this->commissionCalculator->calculateTransactionCommission($transaction);

        $this->assertEquals(2, $commission);
    }
}
