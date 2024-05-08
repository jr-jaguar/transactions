<?php

use App\Domain\Commission\CommissionStrategyManager;
use App\Domain\Model\TransactionBuilder;
use App\Domain\Service\TransactionCommissionService;
use App\Infrastructure\BinProvider\BinApiAdapter;
use App\Infrastructure\CurrencyRatesProvider\ExchangeRatesApi;
use App\Infrastructure\FileParser\FileParser;

require_once __DIR__ . '/../vendor/autoload.php';

if (!isset($argv[1]) || !file_exists($argv[1])) {
    echo "Input file not found." . PHP_EOL;
    exit(1);
}

$inputFile = $argv[1];

try {
    $fileParser = new FileParser();

    $transactions = $fileParser->parseTransactions($inputFile);
    $transactionBuilder = new TransactionBuilder();
    $currencyRatesProvider = new ExchangeRatesApi();
    $binProvider = new BinApiAdapter();
    $strategyManager = new CommissionStrategyManager($binProvider);
    $commissionService = new TransactionCommissionService($strategyManager, $currencyRatesProvider);


    foreach ($transactions as $transactionData) {
        $transaction = $transactionBuilder
            ->setBin($transactionData['bin'])
            ->setAmount($transactionData['amount'])
            ->setCurrency($transactionData['currency'])
            ->build();


        $commission = $commissionService->calculateCommission($transaction);

        echo $commission . PHP_EOL;
    }
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
