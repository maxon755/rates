<?php

declare(strict_types=1);

namespace App\Domain\CountryResolver;

use App\Domain\Country;

interface CountryResolver
{
    /**
     * @param int $bin
     * @return Country
     *
     * @throws CountryResolvingException
     */
    public function resolveCountryByBin(int $bin): Country;
}
