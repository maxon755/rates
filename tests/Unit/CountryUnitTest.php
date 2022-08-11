<?php

declare(strict_types=1);

use App\Domain\Country;
use PHPUnit\Framework\TestCase;

class CountryUnitTest extends TestCase
{
    /**
     * @test
     */
    public function it_determines_eu_country()
    {
        $this->assertTrue((new Country('FR'))->isEUCountry());
    }

    /**
     * @test
     */
    public function it_determines_non_eu_country()
    {
        $this->assertFalse((new Country('UA'))->isEUCountry());
    }
}
