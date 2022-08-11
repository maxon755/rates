<?php

require 'vendor/autoload.php';

use App\BinListCountryResolver;
use App\Domain\CommissionCalculator;
use App\Domain\Money\Currency;
use App\Domain\Money\Money;
use App\Domain\Transaction;
use App\ExchangeRatesCurrencyConverter;
use App\FileReader;

checkArguments($argc, $argv);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required('EXCHANGE_RATES_API_TOKEN');


$inputFileName = $argv[1];
$filePath = __DIR__ . '/' . $inputFileName;


$commissionCalculator = buildCommissionCalculator();
$fileReader = new FileReader();

/** @var string $line */
foreach ($fileReader->read($filePath) as $line) {
    /**
     * @var array{bin: int, amount: float, currency: string} $transactionData
     */
    $transactionData = json_decode($line, associative: true);

    $transaction = new Transaction(
        $transactionData['bin'],
        new Money($transactionData['amount'], Currency::from($transactionData['currency']))
    );

    $commission = $commissionCalculator->calculateTransactionCommission($transaction);

    echo $commission->amount . PHP_EOL;
}

function buildCommissionCalculator(): CommissionCalculator
{
    $countryResolver = new BinListCountryResolver();
    $currencyConverter = new ExchangeRatesCurrencyConverter($_ENV['EXCHANGE_RATES_API_TOKEN']);

    return new CommissionCalculator($countryResolver, $currencyConverter);
}

/**
 * @param int $argc
 * @param array<mixed> $argv
 */
function checkArguments(int $argc, array $argv): void
{
    if ($argc != 2) {
        $scriptName = basename($argv[0]);

        echo "usage: php $scriptName data_file_path" . PHP_EOL;
        exit(1);
    }
}
