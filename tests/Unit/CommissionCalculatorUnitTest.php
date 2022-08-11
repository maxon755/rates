<?php

declare(strict_types=1);

use App\Domain\CommissionCalculator;
use App\Domain\Country;
use App\Domain\CountryResolver\CountryResolver;
use App\Domain\CurrencyConverter\CurrencyConverter;
use App\Domain\Money\Currency;
use App\Domain\Money\Euro;
use App\Domain\Money\Money;
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
            42424242,
            new Euro(100.00),
        );

        $this->countryResolver->expects($this->once())
            ->method('resolveCountryByBin')
            ->with($transaction->bin)
            ->willReturn(new Country('FR'));

        $this->currencyConverter
            ->expects($this->never())
            ->method('convertToEuro');

        $commission = $this->commissionCalculator->calculateTransactionCommission($transaction);

        $this->assertEquals(1, $commission->amount);
    }

    /**
     * @test
     */
    public function it_can_calculate_commission_for_non_euro_credit_card(): void
    {
        $transaction = new Transaction(
            42424242,
            new Euro(100.00),
        );

        $this->countryResolver->expects($this->once())
            ->method('resolveCountryByBin')
            ->with($transaction->bin)
            ->willReturn(new Country('UA'));

        $this->currencyConverter
            ->expects($this->never())
            ->method('convertToEuro');

        $commission = $this->commissionCalculator->calculateTransactionCommission($transaction);

        $this->assertEquals(2, $commission->amount);
    }

    /**
     * @test
     */
    public function it_can_calculate_commission_for_non_euro_currency(): void
    {
        $transaction = new Transaction(
            42424242,
            new Money(4000.00, Currency::UAH),
        );

        $this->countryResolver->expects($this->once())
            ->method('resolveCountryByBin')
            ->with($transaction->bin)
            ->willReturn(new Country('UA'));

        $this->currencyConverter
            ->expects($this->once())
            ->method('convertToEuro')
            ->willReturn(new Euro(100.00))
        ;

        $commission = $this->commissionCalculator->calculateTransactionCommission($transaction);

        $this->assertEquals(2, $commission->amount);
    }

    /**
     * @test
     */
    public function it_rounds_up_commission()
    {
        $transaction = new Transaction(
            42424242,
            new Euro(46.180),
        );

        $this->countryResolver
            ->method('resolveCountryByBin')
            ->willReturn(new Country('FR'));

        $commission = $this->commissionCalculator->calculateTransactionCommission($transaction);

        $this->assertEquals(0.47, $commission->amount);
    }
}
