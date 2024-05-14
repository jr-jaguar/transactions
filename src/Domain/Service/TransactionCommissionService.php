<?php

namespace App\Domain\Service;

use App\Domain\Commission\CommissionStrategyManager;
use App\Domain\Model\Interfaces\TransactionInterface;
use App\Infrastructure\CurrencyRatesProvider\CurrencyRatesProviderInterface;

class TransactionCommissionService
{
    public function __construct(
        private CommissionStrategyManager $strategyManager,
        private CurrencyRatesProviderInterface $currencyRatesProvider
    ) {
    }

    public function calculateCommission(TransactionInterface $transaction): float
    {
        try {
            $commissionRate = $this->strategyManager->getCommissionCoefficient($transaction);
            $exchangeRate = $this->currencyRatesProvider->getExchangeRate($transaction->getCurrency());
            $commission = $this->calculateRawCommission($transaction->getAmount(), $exchangeRate, $commissionRate);

            return $this->roundUpCommission($commission);
        } catch (\Exception $e) {
            echo'Error calculating commission: ' . $e->getMessage() ."\n";
            return 0;
        }
    }

    private function calculateRawCommission(float $amount, float $exchangeRate, float $commissionRate): float
    {
        if ($amount <= 0 || $exchangeRate <= 0 || $commissionRate <= 0) {
            throw new \Exception('Invalid parameters for commission calculation');
        }
        return $amount * $exchangeRate * $commissionRate;
    }

    private function roundUpCommission(float $commission): float
    {
        return ceil($commission * 100) / 100;
    }
}
