<?php

declare(strict_types=1);

namespace App\Domain\CountryResolver;

use App\Domain\Country;

interface CountryResolver
{
    public function resolveCountryByBin(int $bin): Country;
}
