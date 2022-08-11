<?php

declare(strict_types=1);

namespace App;

use App\Domain\CurrencyConverter\CurrencyConverter;
use App\Domain\CurrencyConverter\CurrencyConverterException;
use App\Domain\Money\Currency;
use App\Domain\Money\Money;
use GuzzleHttp\Client;

class ExchangeRatesCurrencyConverter implements CurrencyConverter
{
    private readonly string $url;
    private readonly string $apiToken;
    private readonly Client $client;

    public function __construct(string $apiToken)
    {
        $this->url = 'https://api.apilayer.com/exchangerates_data/';
        $this->apiToken = $apiToken;

        $this->client = new Client([
            'base_uri' => $this->url,
        ]);
    }


    public function convertToEuro(Money $moneyFrom): Money
    {
        try {
            $response = $this->client->get('convert', [
                'query' => [
                    'from' => $moneyFrom->currency->value,
                    'to' => Currency::EUR->value,
                    'amount' => $moneyFrom->amount
                ],
                'headers' => [
                    'apikey' => $this->apiToken
                ]
            ]);

            /**
             * @var array{result: float}
             */
            $exchangeData = json_decode((string) $response->getBody(), associative: true);

            $convertedAmount = $exchangeData['result'];
        } catch (\Throwable $exception) {
            throw new CurrencyConverterException($exception->getMessage());
        }


        return new Money($convertedAmount, Currency::EUR);
    }
}
