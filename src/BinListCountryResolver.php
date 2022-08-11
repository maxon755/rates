<?php

declare(strict_types=1);

namespace App;

use App\Domain\Country;
use App\Domain\CountryResolver\CountryResolver;
use App\Domain\CountryResolver\CountryResolvingException;

class BinListCountryResolver implements CountryResolver
{
    public function resolveCountryByBin(int $bin): Country
    {
        $response = file_get_contents('https://lookup.binlist.net/' . $bin);

        if (!$response) {
            throw new CountryResolvingException('Failed to fetch data');
        }

        try {
            /** @var array{country: array{alpha2: string}} $binData */
            $binData = json_decode($response, associative: true, flags: JSON_THROW_ON_ERROR);
        } catch (\Throwable $exception) {
            throw new CountryResolvingException($exception->getMessage());
        }

        return new Country($binData['country']['alpha2']);
    }
}
